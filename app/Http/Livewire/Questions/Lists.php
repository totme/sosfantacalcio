<?php

namespace App\Http\Livewire\Questions;

use App\Models\Question;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Lists extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;

    public function render()
    {
        $questions =  Question::where('created_by','<>', \auth()->id())
            ->leftjoin('question_answers', 'question_answers.question_id', 'questions.id')
            ->where('expiration_time', '>', Carbon::now())
            ->whereNull('question_answers.answer_by')->orWhere('question_answers.answer_by', '<>', \auth()->id())
            ->select('questions.*')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.questions.lists', ['questions' => $questions]);
    }

}
