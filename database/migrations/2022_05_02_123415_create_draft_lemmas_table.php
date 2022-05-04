<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftLemmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_lemmas', function (Blueprint $table) {
            $table->id();
            $table->string('lemma')->nullable(false)->comment("Lemma's name value");
            $table->string('lemma_form')->nullable(false)->comment("Lemma's form value");
//            $table->string('pos', 50)->nullable(false)->default("noun")->comment("Part of speech");
            $table->unsignedInteger('frequency')->nullable(false)->default(10000)->comment("Lemma's frequency value");
            $table->boolean('is_exception')->default(false)->comment("Lemma's equal value");
//            $table->unique(['lemma', 'lemma_form', 'pos']);
            $table->unique(['lemma', 'lemma_form']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft_lemmas');
    }
}
