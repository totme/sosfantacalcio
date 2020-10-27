<div class="container mt-4">
    <div class="card .shadow-right">
        <div class="card-header text-white bg-blue">
            {{$question->question_text}}

        </div>
        <div class="card-footer">
            <span class="text-gray-500">Risposte minime: 1 | Risposte massime: {{(int)$question->max_answers}}</span>
            <small class="float-right text-gray-500">  Scadenza:
                {{\Carbon\Carbon::parse($question->expiration_time)->format('d-m-Y')}}
                alle {{\Carbon\Carbon::parse($question->expiration_time)->format('H:i')}}</small>

        </div>
        <div class="card-body">

            <ul class="list-group list-group-flush">
                @foreach($players as $player)
                    <li class="list-group-item">
                        <label class="checkboxRadio">
                            <input wire:click="checked" wire:model="answers.{{$player['id']}}" name="answer" type="checkbox"  />
                            <span class="primary"></span>
                        </label>
                        {{$player['name']}} <small class="text-gray-500">{{$player['team']}}</small>
                    </li>
                @endforeach
            </ul>

        </div>

        <button class="btn btn-primary btn-block text-white"  @if(count($answers) == 0 || count($answers) > (int)$question->max_answers) disabled  @endif wire:click="save">{{count($answers)}}/{{(int)$question->max_answers}}  </button>

    </div>
</div>
