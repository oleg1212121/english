<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translation_word', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id');
            $table->unsignedBigInteger('translation_id');
            $table->unique(['translation_id', 'word_id']);
        });
        Schema::table('translation_word', function (Blueprint $table) {
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
            $table->foreign('translation_id')->references('id')->on('translations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translation_word');
    }
}
