<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;
    protected $fillable = ['word', 'description', 'frequency', 'known'];

    public function translations()
    {
        return $this->belongsToMany(Translation::class);
    }
}
