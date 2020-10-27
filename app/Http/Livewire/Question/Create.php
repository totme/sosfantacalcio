<?php

namespace App\Http\Livewire\Question;

use App\Models\Player;
use Livewire\Component;

class Create extends Component
{
    public $search = '';
    public $searchResults = [];

    public function mount()
    {
        //$this->players = Player::all();
    }

    public function render()
    {
        if (strlen($this->search) >= 2) {
            $this->searchResults = Player::where('name', 'like', '%' . $this->search . '%')->get();
        }
        return view('livewire.question.create');
    }

    public function save()
    {
        dd($this->search);
    }
}
