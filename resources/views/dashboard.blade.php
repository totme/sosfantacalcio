@extends('layouts.app')

@section('title', 'Home')


@section('content')
    <div class="row">
        <div class="col-md-4  col-sm-4">
            <div class="container mt-2">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Domande </div>
                                <div class="text-lg font-weight-bold">{{auth()->user()->questions}}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle feather-xl text-white-50"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4  col-sm-4">
            <div class="container mt-2">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Risposte</div>
                                <div class="text-lg font-weight-bold">{{auth()->user()->answers}}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle feather-xl text-white-50"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4  col-sm-4">
            <div class="container mt-2">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Ringraziamenti</div>
                                <div class="text-lg font-weight-bold">{{auth()->user()->thanks}}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle feather-xl text-white-50"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-8 col-sm-12">
            @include('questions.lists')
        </div>
        <div class="col-md-4  col-sm-12">

            <div class="container mt-4">
                <div class="card .shadow-right">
                    <div class="card-header text-dark bg-white">
                        Le ultime domande delle Redazione
                    </div>
                    <div class="card-body">
                        @foreach($lastQuestions as $question)
                            <div class="timeline timeline-xs">
                                <!-- Timeline Item 1-->
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">{{\Carbon\Carbon::parse($question->created_at)->diffForHumans()}}</div>
                                        @if(\Carbon\Carbon::parse($question->expiration_time) > \Carbon\Carbon::now())
                                        <div class="timeline-item-marker-indicator bg-green"></div>
                                        @else
                                            <div class="timeline-item-marker-indicator bg-red"></div>
                                        @endif
                                    </div>
                                    <div class="timeline-item-content">
                                        {{$question->question_text}} <br/><small><a href="{{route('question.show', ['uuid' => $question->uuid])}}">Link</a> </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container mt-4">
                <div class="card .shadow-right">
                    <div class="card-header text-dark bg-white">
                        Utenti più attivi
                    </div>
                    <div class="card-body">
                        @foreach($topUsers as $user)
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-shrink-0 mr-3">
                                    <div class="avatar avatar-xl mr-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{$user->profile_photo_path}}" alt=""></div>
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a class="text-dark line-height-normal mb-1" href="#!">{{$user->name}}</a>
                                        {{$user->answers}} <small>Riposte</small>
                                        {{-- <div class="small text-muted line-height-normal">Vedi profilo</div>--}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
