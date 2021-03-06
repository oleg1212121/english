<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lemmas', function (Blueprint $table) {
            $table->id();
            $table->string('lemma')->nullable(false)->comment("Lemma's name value");
//            $table->string('pos', 50)->nullable(false)->comment("Part of speech");
            $table->unsignedInteger('frequency')->nullable(false)->comment("Lemma's frequency value");
//            $table->unique(['lemma', 'pos']);
            $table->unique(['lemma']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lemmas');
    }
}
