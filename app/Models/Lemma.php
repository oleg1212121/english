<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lemma extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lemmas';
//    protected $fillable = ['lemma', 'pos', 'frequency'];
    protected $fillable = ['lemma', 'frequency'];
}
