<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Word $word
     * @return \Illuminate\Http\Response
     */
    public function learning(Request $request, Word $word)
    {
        $status = $word->known + $request->status;
        if ($status < 0) $status = 0;
        if ($status > 10) $status = 10;


        $word->update([
            'known' => $status
        ]);

        return response('all good', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Word $word
     * @return \Illuminate\Http\Response
     */
    public function removing( Word $word)
    {
        $word->delete();
        return response('all good', 200);
    }

    /**
     * Excluding translation from word.
     *
     * @param Word $word
     * @param Translation $translation
     * @return \Illuminate\Http\Response
     */
    public function translationExcluding( Word $word, int $id)
    {
        $word->translations()->detach($id);
        return response('all good', 200);
    }
}
