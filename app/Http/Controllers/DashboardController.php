<?php

namespace App\Http\Controllers;

use App\Enum\QuestionType;
use App\Libraries\CustomLog;
use App\Models\Player;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    //

    public function show()
    {
        $questions =  Question::where('created_by','<>', \auth()->id())
            ->leftjoin('question_answers', 'question_answers.question_id', 'questions.id')
            ->where('expiration_time', '>', Carbon::now())
            ->whereNull('question_answers.answer_by')->orWhere('question_answers.answer_by', '<>', \auth()->id())
            ->select('questions.*')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $topUsers = User::orderBy('answers', 'desc')->limit(5)->get();
        $lastQuestions = Question::where(['byApp' => true])->orderBy('created_at', 'desc')->limit(5)->get();
        return view('dashboard')
            ->with('questions', $questions)
            ->with('lastQuestions',$lastQuestions)
            ->with('topUsers',$topUsers);
    }

    public function create()
    {
        $players = Player::where('season', Cache::get('season'))->get();
        return view('questions.create')->with('players', $players);
    }

    public function store(Request $request)
    {
        $players = [];
        if (empty($request->get('players')) || count($request->get('players')) < 2) {
            return redirect()->back()->with('error', 'devi selezionare almeno 2 giocatori');
        }
        $playersIds = Cache::get('playersIds');
        foreach ($request->get('players') as $player) {
            $players[] = [
                'id' => $playersIds[$player]['id'],
                'role' => $playersIds[$player]['role'],
                'team' => $playersIds[$player]['team'],
                'name' => $player
            ];
        }

        DB::beginTransaction();
        try {
            Question::create([
                'uuid' => Str::uuid(),
                'max_answers' => 1,
                'players' => \json_encode($players),
                'question_text' => $this->createTextForQuestion(QuestionType::FORMATION, (int)$request->get('anonymous')),
                'question_type' => QuestionType::FORMATION,
                'created_by' => \auth()->user()->id,
                'anonymous' => (int)$request->get('anonymous') == 1,
                'expiration_time' => Carbon::now()->addDays(1),
                'ref' => Str::random(45)
            ]);

            \auth()->user()->changeValue(User::OPERATION_INCREMENT, User::TYPE_QUESTIONS, 1);
            \auth()->user()->changeValue(User::OPERATION_DECREMENT, User::TYPE_CREDITS, 1);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            CustomLog::_log($e->getMessage(), __CLASS__, 'error', ['user_id' =>\auth()->user()->id, 'operation' =>QuestionType::FORMATION]);
            return redirect()->back()->with('opps', 'Opps, si è verificato un errore, riprova più tardi');
        }

        return redirect()->route('dashboard')->with('generic.message', 'Complimenti la tua domanda è stata inserita');
    }

    public function createTextForQuestion($type, $anonymous)
    {
        switch ($type) {
            case QuestionType::FORMATION:
                if($anonymous == 2) {
                    return $this->randomTextWithNameForFormation();
                } else {
                    return "Tu chi metteresti in campo?";
                }
        }
    }

    private function randomTextWithNameForFormation()
    {
        $rand[0] = ucwords(\auth()->user()->name).' non sa chi mettere, tu chi metteresti?';
        $rand[1] = "Aiuta ".ucwords(\auth()->user()->name).' a mettere la formazione giusta';

        return $rand[rand(0,1)];
    }
}
