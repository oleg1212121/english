<?php

namespace Tests\Feature;

use App\Http\Controllers\WordController;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class WordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller = null;
    protected $ratings = [];
    protected $frequency = 0;
    protected const NUMBER_OF_THE_ROWS = 3;

    public function setUp() : void
    {
        parent::setUp();
        $this->controller = new WordController();
        $this->ratings = [0,1,2,3,4,5,6,7,8,9,10];
        $this->frequency = 10000;

        Word::factory()
            ->count(static::NUMBER_OF_THE_ROWS)->create();
    }

    public function test_index()
    {
        $request = Request::create("/words", 'GET',[
            'ratings' => $this->ratings,
            'frequency' => $this->frequency,
        ]);

        $return = $this->controller->index($request);
        $data = $return->getData();
        $this->assertTrue(static::NUMBER_OF_THE_ROWS === $data["words"]->total(), "Number of the rows is wrong");
        $this->assertTrue($this->ratings === $data["ratings"], "The 'ratings' variable is wrong");
        $this->assertTrue($this->frequency === $data["frequency"], "The 'frequency' variable is wrong");
    }


    public function test_reverse()
    {
        $request = Request::create("/words/reverse", 'GET',[
            'ratings' => $this->ratings,
            'frequency' => $this->frequency,
        ]);

        $return = $this->controller->reverse($request);
        $data = $return->getData();
        $this->assertTrue(static::NUMBER_OF_THE_ROWS === $data["words"]->total(), "Number of the rows is wrong");
        $this->assertTrue($this->ratings === $data["ratings"], "The 'ratings' variable is wrong");
        $this->assertTrue($this->frequency === $data["frequency"], "The 'frequency' variable is wrong");
    }

    public function test_statistic()
    {
        $request = Request::create("/statistic", 'GET',[
            'frequency' => $this->frequency,
        ]);
        $return = $this->controller->statistic($request);
        $data = $return->getData();

        $this->assertTrue(is_array($data['statistic']['stat']), "The 'stat' variable is not an array");
        $this->assertTrue(static::NUMBER_OF_THE_ROWS === $data['statistic']['sum'], "Number of the rows is wrong");
        $this->assertTrue($this->frequency === $data["frequency"], "The 'frequency' variable is wrong");
    }
}
