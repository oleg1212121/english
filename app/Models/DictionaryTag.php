<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionaryTag extends Model
{
    use HasFactory;
    protected $table = "dictionary_tags";
    protected $fillable = ['name', 'description'];

    public function words()
    {
        return $this->belongsToMany(Word::class, "dictionary_tag_word", "tag_id", "word_id");
    }
}
