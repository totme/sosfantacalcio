<?php

namespace App\Http\Livewire\Question;

use App\Enum\Role;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Show extends Component
{
    public $uuid, $question, $userAnswers;

    public $ip;
    public $totalAnswers, $totalAnonymousAnswers = 0;
    public $routeName = '';
    public $status = 1; // 1 is open 2 is closed 3 already voted
    public $players, $answers, $totalAnswerVotes, $genericAnswers, $playersIds = [];
    public $byApp = false;

    public function save()
    {

        if (count($this->answers) == 0) {
            session()->flash('error', 'Devi inserire almeno una preferenza');
        } elseif (count($this->answers) > (int)$this->question->max_answers) {
            session()->flash('error', 'Hai inserito più preferenze.');
        } elseif (Carbon::parse($this->question->expiration_time) < Carbon::now()) {
            $this->status = 2;
            session()->flash('error', 'Il tempo è scaduto');
        } else {
            foreach ($this->answers as $answer => $value) {
                QuestionAnswer::create(
                    [
                        'question_id' => $this->question->id,
                        'uuid' => $this->question->uuid,
                        'answer_by' => auth()->check() ? auth()->id() : null,
                        'ip' => $this->ip,
                        'vote' => $answer
                    ]
                );

                $this->question->answers++;
                $this->question->save();
                if (auth()->check()) {
                    \auth()->user()->changeValue(User::OPERATION_INCREMENT, User::TYPE_ANSWERS, 1);
                }

            }
            $this->result();
            session()->flash('message', 'Grazie per il tuo contributo');
            $this->status = 3;

        }


    }

    public function checked()
    {
        if (count($this->answers) > 0) {
            foreach ($this->answers as $id => $answer) {
                if (empty($answer)) {
                    unset($this->answers[$id]);
                }
            }
        }
    }

    public function mount()
    {
        $this->routeName = \Request::route()->getName();
        $this->answers = $this->question = [];
        $this->ip = request()->ip();
        $this->question = Question::where('uuid', $this->uuid)->first();
        if (Carbon::parse($this->question->expiration_time) < Carbon::now()) {
            $this->status = 2;
        } elseif (auth()->check()) {

            $this->userAnswers = QuestionAnswer::where(['answer_by' => auth()->id(), 'uuid' => $this->question->uuid])->get();
            if ($this->userAnswers->count() > 0) {
                $this->status = 3;
            }

            if ($this->question->created_by == auth()->id() && $this->question->byApp == false) {
                $this->status = 3;
            }
        } else {
            $this->userAnswers = QuestionAnswer::where(['ip' => $this->ip, 'uuid' => $this->question->uuid])->get();
            if ($this->userAnswers->count() > 0) {
                $this->status = 3;
            }
        }

        $this->byApp = $this->question->byApp;
        $this->players = \json_decode($this->question->players, true);
        $this->getPlayersByIds();
        $this->result();

    }

    private function getPlayersByIds()
    {
        $playersIds = Cache::get('playersIds');
        foreach ($playersIds as $name => $player) {
            $this->playersIds[$player['id']] = $player;
            $this->playersIds[$player['id']]['name'] = $name;
        }
    }

    public function result()
    {

        $totalAnswers = QuestionAnswer::where(['uuid' => $this->question->uuid])->selectRaw('count(vote) as count, vote')->groupBy('vote')->get();
        $this->totalAnswers = 0;
        if (!empty($totalAnswers)) {
            foreach ($totalAnswers as $totalAnswer) {
                $this->totalAnswers += (int)$totalAnswer['count'];
                $this->totalAnswerVotes[$totalAnswer['vote']] = (int)$totalAnswer['count'];
            }

            if(auth()->check()) {
                if (auth()->id() == $this->question->created_by || auth()->user()->role == Role::SUPERADMIN) {
                    $genericAnswers = QuestionAnswer::where(['uuid' => $this->question->uuid])->orderBy('created_at', 'desc')->paginate(100);
                    $this->totalAnonymousAnswers = 0;
                    foreach ($genericAnswers as $genericAnswer) {
                        if (!empty($genericAnswer->answer_by)) {

                            $user = $genericAnswer->user;

                            $this->genericAnswers[$user->id]['uuid'] = $genericAnswer->uuid;
                            $this->genericAnswers[$user->id]['thanks'] = $genericAnswer->thanks_by_author;
                            $this->genericAnswers[$user->id]['user'] = $user;
                            $this->genericAnswers[$user->id]['votes'][$genericAnswer['vote']] =
                                ['player' => $this->playersIds[$genericAnswer['vote']], 'value' => $genericAnswer['value']];
                        } else {
                            $this->totalAnonymousAnswers++;
                        }
                    }
                }
            }


        }
    }

    public function thanks($type, $userId)
    {
        if ($type == 0) {
            User::where('id', $userId)->decrement('thanks', 1);
            QuestionAnswer::where(['uuid' => $this->question->uuid, 'answer_by' => $userId])->update(['thanks_by_author' => 0]);
        } else {
            User::where('id', $userId)->increment('thanks', 1);
            QuestionAnswer::where(['uuid' => $this->question->uuid, 'answer_by' => $userId])->update(['thanks_by_author' => 1]);
        }

        $this->result();
    }

    public function render()
    {
        return view('livewire.question.show');
    }
}
