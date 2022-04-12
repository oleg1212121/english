<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    const DEFAULT_FREQUENCY = 3000;
    const DEFAULT_PAGINATE = 100;

    public function index(Request $request)
    {
        $ratings = $request->input('ratings', []);
        $frequency = $request->input('frequency', static::DEFAULT_FREQUENCY);
        $words = Word::when($frequency, function ($query, $frequency) {
            return $query->where('frequency', '<=', $frequency);
        })->when($ratings, function ($query, $ratings) {
            return $query->whereIn('known', $ratings);
        })->with(['translations'])->orderBy('frequency')->orderBy('word')->paginate(static::DEFAULT_PAGINATE);

        return view('words.word_list', compact('words', 'frequency', 'ratings'));
    }

    public function reverse(Request $request)
    {
        $ratings = $request->input('ratings', []);
        $frequency = $request->input('frequency', static::DEFAULT_FREQUENCY);
        $words = Word::when($frequency, function ($query, $frequency) {
            return $query->where('frequency', '<=', $frequency);
        })->when($ratings, function ($query, $ratings) {
            return $query->whereIn('known', $ratings);
        })->with(['translations'])->orderBy('frequency')->orderBy('word')->paginate(static::DEFAULT_PAGINATE);

        return view('words.word_list_reverse', compact('words', 'frequency', 'ratings'));
    }

    public function statistic(Request $request)
    {
        $frequency = $request->input('frequency', static::DEFAULT_FREQUENCY);

        $groups = \DB::table('words')
            ->select(\DB::raw('count(*) as count, known'))
            ->whereIn('known', range(1,10))
            ->where('frequency', '<=', $frequency)
            ->groupBy('known')
            ->orderBy('known', 'desc')
            ->get();

        $statistic = [
            'stat' => ['10' => 0, '9' => 0, '8' => 0, '7' => 0, '6' => 0, '5' => 0, '4' => 0, '3' => 0, '2' => 0, '1' => 0],
            'sum' => 0
        ];

        foreach ($groups as $group) {
            $statistic['stat'][$group->known] = $group->count;
        }

        $statistic['sum'] = array_sum($statistic['stat']);

        return view('words.statistic', compact('statistic', 'frequency'));
    }

}
