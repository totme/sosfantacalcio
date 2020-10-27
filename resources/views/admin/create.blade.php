@extends('layouts.app')

@section('title', 'Crea una domanda')


@section('content')
    <div>

        @if (session()->has('message'))
            <div class="container mt-2 mb-2">
                <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                    {{ session('message') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        @endif
        @if (session()->has('opps'))
            <div class="container mt-2 mb-2">
                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>                        {{ session('opps') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="container mt-2 mb-2">
                <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                    {{ session('error') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
    @endif


    <!-- Main page content-->
        <div class="container mt-4">
            <div class="card">
                <form method="POST" action="{{route('admin.store')}}">
                    @csrf
                    <div class="card-header">Crea una domanda</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label>Crea la domanda</label>
                                    <input class="form-control" type="text" name="question" required>
                                    @error('question')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label>Risposte massimo</label>
                                   <select name="max_answers" class="form-control">
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                   </select>
                                    @error('question')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label>Tipo di domanda</label>
                                    <select name="question_type" class="form-control">
                                        @foreach(\App\Enum\QuestionType::getQuestionType() as $type)
                                            <option value="{{$type}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                    @error('question')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label >Seleziona i giocatori in ballottagio <small class="text-gray-500">Seleziona almeno 2 giocatori</small> </label>
                                    <select class="players form-control-lg custom-select-lg" name="players[]" multiple data-placeholder="Cerca un giocatore..." data-allow-clear="1">
                                        @foreach($players as $player)
                                            <option>{{$player->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('players')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-lg btn-block">Crea la domanda e chiedi alla community</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>


    </div>

@endsection
