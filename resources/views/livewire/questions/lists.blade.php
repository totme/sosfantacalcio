<div>
    {{$perPage}}
    @foreach($questions as $question)
        @livewire('question.show', ['uuid' => $question->uuid], key($question->uuid))
    @endforeach

    @if(count($questions) > 0 && $questions->hasMorePages())
            <a wire:click="showMore" class="btn btn-danger">Carica altre domande </a>
    @endif

</div>
