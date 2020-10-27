<?php

namespace App\Imports;

use App\Enum\PlayerRole;
use App\Models\Player;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\ToModel;

class PlayersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!empty($row[1]) && $row[0] != 'Id') {
            $player = new Player();

            return $player->updateOrCreate(
                [
                    'name' => $row[2]
                ],
                [
                    'role' => PlayerRole::convertByFantagazzetta($row[1]),
                    'team' => $row[3],
                    'season' => Cache::get('season')
                ]
            );
        }
    }
}
