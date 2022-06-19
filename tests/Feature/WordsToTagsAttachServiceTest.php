<?php

namespace Tests\Feature;

use App\Models\DictionaryTag;
use App\Models\Word;
use App\Services\DictionaryTagsServices\WordsToTagsAttachService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WordsToTagsAttachServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $tag = null;
    protected $words = [];
    protected $service = null;
    protected $defaultWordsNumber = 3;
    protected $defaultTagNumber = 1;

    protected function setUp(): void
    {
        parent::setUp();
        DictionaryTag::factory()->count($this->defaultTagNumber)->create();
        Word::factory()->count($this->defaultWordsNumber)->create();

        $this->tag = DictionaryTag::firstOrFail();
        $this->words = Word::pluck('word')->toArray();

        $this->service = new WordsToTagsAttachService($this->tag, $this->words);

    }

    public function test_execute()
    {
        $this->tag->load('words');
        $this->assertTrue([] === $this->tag->words->toArray(), "Tag has some unexpected relations");
        $this->service->execute();
        $this->tag->load('words');
        $this->assertTrue($this->defaultWordsNumber === $this->tag->words->count(), "Relation did not create");
    }

    public function test_set_words_with_number_of_rows_600()
    {
        $arr = \Faker\Factory::create()->words(600);
        $this->service->setWords($arr);
        $this->service->execute();
        $this->tag->load('words');
        $this->assertTrue([] === $this->tag->words->toArray(), "Tag has some unexpected relations");
    }

    public function test_set_words_with_number_of_rows_0()
    {
        $this->service->setWords([]);
        $this->service->execute();
        $this->tag->load('words');
        $this->assertTrue([] === $this->tag->words->toArray(), "Tag has some unexpected relations");
    }

    public function test_create_an_empty_service()
    {
        $service = new WordsToTagsAttachService();
        $result = $service->execute();

        $this->assertTrue(null === $result, "Unexpected return from empty service");
    }
}
