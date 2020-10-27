<?php

namespace App\Console\Commands;

use App\Imports\PlayersImport;
use App\Models\Player;
use App\Models\PlayerFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportPlayerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:player';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $file = PlayerFile::where('imported', false)->first();
        if (empty($file)) {
            return;
        }

        DB::beginTransaction();
        try {
            //Player::truncate();
            $document = Storage::path(str_replace('/storage/', '', $file->path));
            Excel::import(new PlayersImport(), $document);
            Player::where('season', '<>', Cache::get('season'))->delete();
            $players = Player::all();
            $playersIds = [];
            foreach ($players as $player) {
                $playersIds[$player->name]['id'] = $player->id;
                $playersIds[$player->name]['role'] = $player->role;
                $playersIds[$player->name]['team'] = $player->team;
            }
            Cache::put('playersIds', $playersIds);
            $file->imported = true;
            $file->save();
            DB::commit();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }
    }
}
