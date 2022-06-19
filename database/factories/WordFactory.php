<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'word' => str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.time()),
            'description' => 'Some test description of the word',
            'frequency' => rand(151, 9999),
            'known' => array_rand([0,1,2,3,4,5,6,7,8,9,10]),
        ];
    }
}
