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
            $table->unsignedBigInteger('lemma_id')->nullable(false)->comment("Lemma's id. Foreign key.");
            $table->string('lemma_form')->nullable(false)->comment("Lemma's form value");
            $table->boolean('is_exception')->default(false)->comment("Lemma's equal value");

            $table->foreign('lemma_id')->references('id')->on('lemmas')->onDelete('CASCADE');
            $table->unique(['lemma_form', 'lemma_id']);
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
