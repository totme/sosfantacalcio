<?php

namespace App\Http\Livewire\Admin;

use App\Models\PlayerFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PlayerImport extends Component
{
    use WithFileUploads;

    public $file;
    public $season;

    public function render()
    {
        return view('livewire.admin.player-import');
    }

    public function save()
    {
        $this->validate([
            'season' => 'required',
            'file' => 'required|max:1024', // 1MB Max
        ]);


        Cache::put('season', $this->season); // 10 Minutes


        $name = date('YmdHi').'.xlsx';
        $this->file->storeAs('files', $name);
        PlayerFile::create(
            [
                'upload_at' => Carbon::now(),
                'upload_by' => auth()->id(),
                'path' => Storage::url('files/').$name
            ]
        );

        session()->flash('message', 'File caricato, a breve parte l\'import!');
        $this->file = '';
    }
}
