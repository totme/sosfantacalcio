<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show($uuid = null)
    {
        // @todo: control exists uuid
        return view('questions.show')->with('uuid', $uuid);
    }

    public function detail($uuid = null)
    {
        return view('questions.show')->with('uuid', $uuid);
    }

    public function my()
    {
        $questions = Question::where('created_by', auth()->id())->orderBy('created_at', 'desc')->paginate(20);
        return view('questions.my')->with('questions', $questions);
    }
}
