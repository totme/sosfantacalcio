@extends('layouts.app')
@section('title', 'Rispondi alla domanda')


@section('content')

    @livewire('question.show', ['uuid' => $uuid], key($uuid))

@endsection
