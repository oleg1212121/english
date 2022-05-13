<?php

namespace App\Http\Controllers;

use App\Models\DictionaryTag;
use App\Models\Word;
use App\Services\DictionaryTagsServices\WordsToTagsAttachService;
use Illuminate\Http\Request;

class DictionaryWordController extends Controller
{
    public function reverse(Request $request, DictionaryTag $tag)
    {
        $ratings = $request->input('ratings', []);
        $frequency = $request->input('frequency', static::DEFAULT_FREQUENCY);
        $words = Word::whereHas("tags", function ($query) use ($tag) {
            $query->where('dictionary_tags.id', $tag->id);
        })->when($frequency, function ($query, $frequency) {
            return $query->where('frequency', '<=', $frequency);
        })->when($ratings, function ($query, $ratings) {
            return $query->whereIn('known', $ratings);
        })->with(['translations', 'tags'])->orderBy('frequency')->orderBy('word')->paginate(static::DEFAULT_PAGINATE);

        return view('words.word_list_reverse', compact('words', 'frequency', 'ratings'));
    }


}
