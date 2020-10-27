<div wire:key="{{$this->uuid}}">
    @if (session()->has('message'))
        <div class="container mt-2 mb-2">
            <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-thumbs-up">
                    <path
                        d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                </svg>
                {{ session('message') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
        </div>
    @endif
    @if (session()->has('opps'))
        <div class="container mt-2 mb-2">
            <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-alert-triangle">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12" y2="17"></line>
                </svg> {{ session('opps') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="container mt-2 mb-2">
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-thumbs-down">
                    <path
                        d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                </svg>
                {{ session('error') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
        </div>
    @endif
    @if($status == 2)
        @include('livewire.question.result')
    @elseif($status == 3)

        @include('livewire.question.result')

    @elseif($status ==  1)
        @include('livewire.question.insert')
    @endif

    @if( auth()->check() &&  ($routeName == 'question.show'))
        @if(!empty($genericAnswers) && count($genericAnswers) > 0 && (auth()->id() == $question->created_by || auth()->user()->role == \App\Enum\Role::SUPERADMIN))
            <div class="container mt-3 mb-2">
                <div class="card">
                    <div class="card-header text-dark bg-white">
                        Ultimi utenti che hanno risposto
                        <small class="float-right text-gray-500">Utenti anonimi: {{$totalAnonymousAnswers}}</small>
                    </div>
                    <div class="card-body">
                        <table class="table" style="width: 100%">
                            <thead>
                            <th>Utente</th>
                            <th>Domande fatte</th>
                            <th>Risposte totali</th>
                            <th>Risposta</th>
                            <th></th>
                            </thead>

                            @foreach($genericAnswers as $user_id => $detail)
                                <tr>
                                    <td>{{$detail['user']->name}}</td>
                                    <td>{{$detail['user']->questions}}</td>
                                    <td>{{$detail['user']->answers}}</td>
                                    <td>
                                        @php $player = ''; @endphp
                                        @foreach($detail['votes'] as $player_id => $vote)
                                            {{$vote['player']['name']}}
                                        @endforeach
                                    </td>

                                    <td>
                                        @if($detail['thanks'] == 1)
                                            <a wire:click="thanks(0, {{$user_id}})">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                                     style="display:inline-block;vertical-align:text-bottom">
                                                    <path
                                                        d="M14 20.408c-.492.308-.903.546-1.192.709-.153.086-.308.17-.463.252h-.002a.75.75 0 01-.686 0 16.709 16.709 0 01-.465-.252 31.147 31.147 0 01-4.803-3.34C3.8 15.572 1 12.331 1 8.513 1 5.052 3.829 2.5 6.736 2.5 9.03 2.5 10.881 3.726 12 5.605 13.12 3.726 14.97 2.5 17.264 2.5 20.17 2.5 23 5.052 23 8.514c0 3.818-2.801 7.06-5.389 9.262A31.146 31.146 0 0114 20.408z"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <a wire:click="thanks(1, {{$user_id}})">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                                     style="display:inline-block;vertical-align:text-bottom">
                                                    <path fill-rule="evenodd"
                                                          d="M6.736 4C4.657 4 2.5 5.88 2.5 8.514c0 3.107 2.324 5.96 4.861 8.12a29.66 29.66 0 004.566 3.175l.073.041.073-.04c.271-.153.661-.38 1.13-.674.94-.588 2.19-1.441 3.436-2.502 2.537-2.16 4.861-5.013 4.861-8.12C21.5 5.88 19.343 4 17.264 4c-2.106 0-3.801 1.389-4.553 3.643a.75.75 0 01-1.422 0C10.537 5.389 8.841 4 6.736 4zM12 20.703l.343.667a.75.75 0 01-.686 0l.343-.667zM1 8.513C1 5.053 3.829 2.5 6.736 2.5 9.03 2.5 10.881 3.726 12 5.605 13.12 3.726 14.97 2.5 17.264 2.5 20.17 2.5 23 5.052 23 8.514c0 3.818-2.801 7.06-5.389 9.262a31.146 31.146 0 01-5.233 3.576l-.025.013-.007.003-.002.001-.344-.666-.343.667-.003-.002-.007-.003-.025-.013A29.308 29.308 0 0110 20.408a31.147 31.147 0 01-3.611-2.632C3.8 15.573 1 12.332 1 8.514z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @elseif(!auth()->check())
            <div class="container mt-5 mb-2">
                <a class="btn btn-primary btn-block btn-lg text-white">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    <strong>Accedi con  Facebook  ed entra nella community</strong></a>
            </div>
    @endif
</div>
