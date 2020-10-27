<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->index();
            $table->boolean('byApp')->default(false);
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->boolean('anonymous')->default(false);
            $table->string('question_text')->nullable();
            $table->string('question_type')->default(\App\Enum\QuestionType::FORMATION);
            $table->json('players');
            $table->bigInteger('answers')->default(0)->index();
            $table->integer('max_answers')->default(1);
            $table->dateTime('expiration_time')->index();
            $table->string('ref');
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
        Schema::dropIfExists('questions');
    }
}
