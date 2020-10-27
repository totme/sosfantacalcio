
    @if($questions->count() == 0)
        <div class="container mt-4">
            <div class="card .shadow-right">
                <div class="card-body">
                    Non ci sono altre domande per il momento
                </div>
            </div>
        </div>

    @else
        @foreach($questions as $question)
                @livewire('question.show', ['uuid' => $question->uuid], key($question->uuid))
        @endforeach
    @endif
