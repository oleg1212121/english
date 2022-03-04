<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word', 255)->unique()->comment('Слово/словосочетание, его написание');
            $table->text('description')->nullable(true)->comment('Описание значения');
            $table->unsignedInteger('frequency')->default(5000)->comment('Частотность использования');
            $table->unsignedSmallInteger('known')->default(0)->comment('Степень изучения');
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
        Schema::dropIfExists('words');
    }
}
