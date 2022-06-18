<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\Api\WordController;
use App\Models\Translation;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class WordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller = null;
    protected $known = 5;
    protected $frequency = 0;
    protected const NUMBER_OF_THE_ROWS = 1;
    protected const NUMBER_OF_THE_TRANSLATIONS = 1;

    public function setUp() : void
    {
        parent::setUp();
        $this->controller = new WordController();
        $this->known = 5;

        Word::factory()
            ->has(Translation::factory()->count(static::NUMBER_OF_THE_TRANSLATIONS), 'translations')
            ->count(static::NUMBER_OF_THE_ROWS)->create([
                'known' => $this->known
            ]);
    }

    public function test_learning_when_known_between_0_and_10()
    {
        $word = Word::firstOrFail();

        $status = 1;
        $request = Request::create("/learning/{$word->id}", 'PATCH',[
            'status' => $status,
        ]);

        $return = $this->controller->learning($request, $word);

        $word = Word::firstOrFail();

        $this->assertTrue($this->known + $status === +$word->known, "Word updating is failed");
        $this->assertTrue(200 === $return->status(), "Response status is wrong");
    }

    public function test_learning_when_known_below_0()
    {
        $word = Word::firstOrFail();
        $status = -100;
        $request = Request::create("/learning/{$word->id}", 'PATCH',[
            'status' => $status,
        ]);

        $this->controller->learning($request, $word);

        $word = Word::firstOrFail();
        $this->assertTrue(0 === +$word->known, "Word updating is failed");
    }


    public function test_learning_when_known_above_10()
    {
        $word = Word::firstOrFail();
        $status = +100;
        $request = Request::create("/learning/{$word->id}", 'PATCH',[
            'status' => $status,
        ]);

        $this->controller->learning($request, $word);

        $word = Word::firstOrFail();
        $this->assertTrue(10 === +$word->known, "Word updating is failed");
    }


    public function test_removing()
    {
        $word = Word::firstOrFail();
        $return = $this->controller->removing($word);
        $word = Word::first();
        $this->assertTrue(null === $word, "Deleting went wrong");
        $this->assertTrue(200 === $return->status(), "Response status is wrong");
    }

    public function test_translationExcluding()
    {
        $word = Word::with('translations')->firstOrFail();
        $translation = Translation::firstOrFail();

        $return = $this->controller->translationExcluding($word, $translation->id);
        $word = Word::with('translations')->firstOrFail();
        $translation = Translation::firstOrFail();

        $this->assertFalse(null === $translation, "Unrelated row was deleted");
        $this->assertTrue([] === $word->translations->toArray(), "Detaching relation went wrong");
        $this->assertTrue(200 === $return->status(), "Response status is wrong");
    }
}
