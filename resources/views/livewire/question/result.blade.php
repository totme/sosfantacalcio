<div class="container mt-4" wire:poll.20s="result">
    <div class="card .shadow-right">
        <div class="card-header text-white bg-blue">
            {{$question->question_text}}

        </div>
        <div class="card-footer">
            <span class="text-gray-500">Risposte totali: {{$totalAnswers}}</span>
            <small class="float-right text-gray-500"> Scadenza:
                {{\Carbon\Carbon::parse($question->expiration_time)->format('d-m-Y')}}
                alle {{\Carbon\Carbon::parse($question->expiration_time)->format('H:i')}}</small>

        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">

                @foreach($players as $player)
                    @php
                        $width=0;
                            if(isset($totalAnswerVotes[$player['id']])) {
                                $width = round((($totalAnswerVotes[$player['id']] / $totalAnswers) *100),0);
                            }

                    @endphp
                    <li class="list-group-item">
                        {{$player['name']}} <small class="text-gray-500">{{$player['team']}}</small>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{$width}}%"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                {{$width}}%
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @if(auth()->check() && auth()->id()  == $question->created_by)
            <div class="card-footer">
                @if($routeName != 'question.show')
                <a href="{{route('question.show', ['uuid' => $question->uuid])}}"><small class="text-gray-500">Guarda
                        chi ha votato</small></a>
                @endif
                <small class="float-right text-gray-500"> Condividi la domanda e guadagna crediti
                    qua i link social
                </small>

            </div>
        @endif
    </div>
</div>
