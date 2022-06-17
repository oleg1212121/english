<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DictionaryTagFactory extends Factory
{
    protected $names = [
        'oxford cefr 3000',
        'oxford cefr 5000',
        'oxford cefr 8000',
        'oxford cefr 10000',
        'oxford cefr 11000',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->names[array_rand($this->names)],
            'description' => 'This is the test description of the dictionary tag'
        ];
    }
}
