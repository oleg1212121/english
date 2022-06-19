<?php


namespace App\Services\DictionaryTagsServices;


use App\Models\DictionaryTag;
use App\Models\Word;

class WordsToTagsAttachService
{
    protected $tag;
    protected $words = [];
    const CHUNK_SIZE = 500;

    public function __construct(DictionaryTag $tag = null, array $words = [])
    {
        $this->tag = $tag;
        $this->words = $words;
    }

    public function execute()
    {
        if(!$this->tag) return null;
        foreach(array_chunk($this->words, static::CHUNK_SIZE) as $arr) {
            $ids = Word::whereIn("word", $arr)->pluck('id')->toArray();
            $this->attach($ids);
        }
    }

    public function setWords(array $words = [])
    {
        $this->words = $words;
        return $this;
    }

    protected function attach(array $arr = [])
    {
        $this->tag->words()->syncWithoutDetaching($arr);
    }
}
