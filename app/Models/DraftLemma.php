<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftLemma extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'draft_lemmas';
//    protected $fillable = ["lemma", 'lemma_form', "is_exception", "pos", "frequency"];
    protected $fillable = ["lemma", 'lemma_form', "is_exception", "frequency"];
}
