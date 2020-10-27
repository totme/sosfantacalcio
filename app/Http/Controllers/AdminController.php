<?php

namespace App\Http\Controllers;

use App\Enum\QuestionType;
use App\Libraries\CustomLog;
use App\Models\Player;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    //

    public function create()
    {
        $players = Player::where('season', Cache::get('season'))->get();
        return view('admin.create')->with('players', $players);
    }


    public function store(Request $request)
    {
        $players = [];
        if (empty($request->get('question')) || empty($request->get('players')) || count($request->get('players')) < 2) {
            return redirect()->back()->with('error', 'Fai la domanda e inserisci almeno 2 giocatori');
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
                'byApp' => true,
                'max_answers' => $request->get('max_answers'),
                'players' => \json_encode($players),
                'question_text' => $request->get('question'),
                'question_type' => $request->get('question_type'),
                'created_by' => \auth()->user()->id,
                'expiration_time' => Carbon::now()->addDays(1),
                'ref' => Str::random(45)
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            CustomLog::_log($e->getMessage(), __CLASS__, 'error', ['user_id' =>\auth()->user()->id, 'operation' =>QuestionType::FORMATION]);
            return redirect()->back()->with('opps', 'Opps, si è verificato un errore, riprova più tardi');
        }

        return redirect()->back()->with('message', 'Complimenti la tua domanda è stata inserita');
    }

    public function playerImport()
    {
        return view('admin.playerImport');
    }


}
