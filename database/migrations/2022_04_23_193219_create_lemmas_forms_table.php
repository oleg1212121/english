<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemmasFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lemmas_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lemma_rank')->nullable(false)->comment("Lemma's rank. Foreign key.");
            $table->string('lemma_form')->nullable(false)->comment("Lemma's form value");

            $table->foreign('lemma_rank')->references('item_rank')->on('lemmas')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unique(['lemma_form', 'lemma_rank']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lemmas_forms');
    }
}
