<?php

namespace Tests\Feature;

use App\Http\Controllers\DictionaryWordController;
use App\Models\DictionaryTag;
use App\Models\Word;
use Database\Seeders\DictionaryTagSeeder;
use Database\Seeders\WordSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class DictionaryWordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $tag = null;
    protected $controller = null;
    protected $ratings = [];
    protected $frequency = 0;
    protected $request = null;
    protected const NUMBER_OF_THE_ROWS = 3;

    public function setUp() : void
    {
        parent::setUp();
        $this->controller = new DictionaryWordController();
        $this->ratings = [0,1,2,3,4,5,6,7,8,9,10];
        $this->frequency = 10000;

        $this->seed(DictionaryTagSeeder::class);

        $tag = DictionaryTag::inRandomOrder()->firstOrFail();
        $this->tag = $tag;

        Word::factory()
            ->hasAttached($tag, [], 'tags')
            ->count(static::NUMBER_OF_THE_ROWS)->create();


        $this->request = Request::create("/dictionary-tags/{$this->tag->id}/words/reverse", 'GET',[
            'tag'  =>  $this->tag,
            'ratings' => $this->ratings,
            'frequency' => $this->frequency,
        ]);
    }

    public function test_reverse()
    {
        $return = $this->controller->reverse($this->request, $this->tag);
        $data = $return->getData();
        $this->assertTrue(static::NUMBER_OF_THE_ROWS === $data["words"]->total(), "Number of the rows is wrong");
        $this->assertTrue($this->ratings === $data["ratings"], "The 'ratings' variable is wrong");
        $this->assertTrue($this->frequency === $data["frequency"], "The 'frequency' variable is wrong");
    }

}
