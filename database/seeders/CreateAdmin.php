<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Libraries\CustomLog;
use App\Models\User;
use App\Notifications\User\SuperAdminCreate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Str::random(12);
        Schema::disableForeignKeyConstraints();
        User::updateOrCreate([
            'email' => getenv('SUPERADMIN_EMAIL'),
            'role' => Role::SUPERADMIN,
            'name' => getenv('SUPERADMIN_NAME'),
            'username' =>  getenv('SUPERADMIN_USERNAME'),
        ], [
            'password' => bcrypt($password)
        ]);

        CustomLog::_log('Utente creato/aggioranto', 'info', __CLASS__, ['email' => getenv('SUPERADMIN_EMAIL'), 'password' => $password]);

        Schema::enableForeignKeyConstraints();
    }
}
