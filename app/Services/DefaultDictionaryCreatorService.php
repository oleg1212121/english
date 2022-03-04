<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 05.11.21
 * Time: 14:54
 */

namespace App\Services;

use App\Models\Translation;
use App\Models\Word;
use Illuminate\Support\Facades\DB;

class DefaultDictionaryCreatorService
{
    /**
     * Defined aliases
     */
    const FILE_NAMES = [
        'words' => '/words.txt',
        'translations' => '/translations.txt',
        'translation_word' => '/translation_word.txt',
    ];

    /**
     * Inserting words to tables, and associating relations to pivot table
     */
    public static function basicSeedingDBFromFiles()
    {
        static::insertingWordsFromFile();
        static::insertingTranslationsFromFile();
        static::insertingTranslationsToPivotFromFile();
    }

    /**
     * Creating files (contains words, translations and relations)
     */
    public static function creatingFilesFromDB()
    {
        static::createWordsDictionaryFile();
        static::createTranslationsDictionaryFile();
        static::createWordsRelatedTranslationsFile();
    }


    /**
     * Creating file with words (dictionary)
     * @throws \Exception
     */
    protected function createWordsDictionaryFile()
    {
        $path = public_path() . static::FILE_NAMES['words'];
        $words = Word::all();
        try {
            $f = fopen($path, 'w');
            foreach ($words as $word) {
                fwrite($f, implode('|', [
                        $word->word,
                        $word->description,
                        $word->frequency,
                        $word->known,
                        $word->created_at,
                        $word->updated_at,
                    ]) . PHP_EOL);
            }

            fclose($f);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Creating file with words (dictionary)
     * @throws \Exception
     */
    protected function createTranslationsDictionaryFile()
    {
        $path = public_path() . static::FILE_NAMES['translations'];
        $words = Translation::all();
        try {
            $f = fopen($path, 'w');
            foreach ($words as $word) {
                fwrite($f, implode('|', [
                        $word->word,
                        $word->description,
                        $word->created_at,
                        $word->updated_at,
                    ]) . PHP_EOL);
            }

            fclose($f);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Creating words translations file
     * @throws \Exception
     */
    protected function createWordsRelatedTranslationsFile()
    {
        $path = public_path() . static::FILE_NAMES['translation_word'];
        $words = Word::with('translations')->get();

        try {
            $f = fopen($path, 'w');
            foreach ($words as $w) {
                $str = $w->word . '|' . implode(', ', $w->translations->pluck('word')->toArray()) . PHP_EOL;

                fwrite($f, $str);
            }

            fclose($f);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Inserting words to DB from file (dictionary)
     * @throws \Exception
     */
    protected function insertingWordsFromFile()
    {
        $path = public_path() . static::FILE_NAMES['words'];
        $data = [];

        try {
            $f = fopen($path, "r");
            if ($f) {
                while (($line = fgets($f)) !== false) {
                    $arr = explode('|', trim($line));
                    array_push($data, [
                        'word' => $arr[0],
                        'description' => $arr[1],
                        'frequency' => $arr[2],
                        'known' => $arr[3],
                        'created_at' => $arr[4],
                        'updated_at' => $arr[5]
                    ]);
                    if(count($data) > 2000){
                        DB::table('words')->insert($data);
                        $data = [];
                    }
                }
                fclose($f);
                DB::table('words')->insert($data);
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Inserting words to DB from file (dictionary)
     * @throws \Exception
     */
    protected function insertingTranslationsFromFile()
    {
        $path = public_path() . static::FILE_NAMES['translations'];
        $data = [];

        try {
            $f = fopen($path, "r");
            if ($f) {
                while (($line = fgets($f)) !== false) {
                    $arr = explode('|', trim($line));
                    array_push($data, [
                        'word' => $arr[0],
                        'description' => $arr[1],
                        'created_at' => $arr[2],
                        'updated_at' => $arr[3]
                    ]);
                    if(count($data) > 2000){
                        DB::table('translations')->insert($data);
                        $data = [];
                    }
                }
                fclose($f);
                DB::table('translations')->insert($data);
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Inserting relations to pivot table
     * @throws \Exception
     */
    protected function insertingTranslationsToPivotFromFile()
    {
        $first = Word::pluck('id', 'word');
        $second = Translation::pluck('id', 'word');
        $path = public_path() . static::FILE_NAMES['translation_word'];
        $data = [];

        try {
            $f = fopen($path, "r");
            if ($f) {
                while (($line = fgets($f)) !== false) {
                    $arr = explode('|', trim($line));

                    $e = $first[trim($arr[0])];
                    foreach (explode(',', $arr[1]) as $item) {
                        array_push($data, [
                            "word_id" => $e,
                            "translation_id" => $second[trim($item)]
                        ]);
                    }
                    if(count($data) > 2000){
                        DB::table('translation_word')->insert($data);
                        $data = [];
                    }
                }
                fclose($f);
                DB::table('translation_word')->insert($data);
            }

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
//        $data = array_chunk($data, 2000);
//        foreach ($data as $item) {
//            DB::table('translation_word')->insert($item);
//        }
    }
}
