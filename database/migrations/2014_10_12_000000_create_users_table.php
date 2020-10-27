<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->bigInteger('credits')->default(10);
            $table->bigInteger('questions')->default(0);
            $table->bigInteger('answers')->default(0);
            $table->bigInteger('thanks')->default(0);
            $table->bigInteger('raise')->default(0);
            $table->bigInteger('shares')->default(0);
            $table->bigInteger('level')->default(1);
            $table->string('role')->default(\App\Enum\Role::USER);
            $table->string('facebook_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
