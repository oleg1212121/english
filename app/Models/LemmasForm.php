<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LemmasForm extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lemmas_forms';
    protected $fillable = ['lemma_id', 'lemma_form', "is_exception"];

    public function lemma()
    {
        return $this->belongsTo(Lemma::class);
    }
}
