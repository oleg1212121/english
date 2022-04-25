<?php


namespace App\Services\Normalizer;


class BasePartOfSpeech
{
    protected static $rule = []; # Правила замены окончаний при нормализации слова по правилам.
    protected static $exceptions = []; # Словарь исключений
    protected static $indexes = []; # Индексный массив
    protected static $exceptionsPath = ''; # Получим путь до файла исключений
    protected static $indexesPath = ''; # Получим путь до индексного словаря
    protected static $cacheWords = []; # Кэш

    public function __construct($pathDict, $excFile, $indexFile)
    {
        static::$exceptionsPath = storage_path($pathDict).$excFile;
        static::$indexesPath = storage_path($pathDict).$indexFile;

        static::parseFile(static::$exceptionsPath, "appendExceptions");
        static::parseFile(static::$indexesPath, "appendIndexes");
    }

    # Метод открывает файл на чтение, читает по одной строке и вызывает для каждой строки функцию, переданную в аргументе
    protected function parseFile($file, $contentHandler)
    {
        try{
            $f = fopen($file, 'r');

            if ($f) {
                while(($line = fgets($f)) !== false) {
                    static::{$contentHandler}($line);
                }
                fclose($f);
            }
        } catch (\Exception $e){
            throw new \Exception('File does not load');
        }
    }

    # Метод добавляет в словарь исключений одно значение.
    # Файл исключений представлен в формате: [слово-исключение][пробел][лемма]
    protected function appendExceptions($line)
    {
        # При разборе строки из файла, каждую строку разделяем на 2 слова и заносим слова в словарь(первое слово - ключ, второе - значение). При этом не забываем убрать с концов пробелы
        $line = trim($line);
        $arr = explode(" ", $line);
        static::$exceptions[trim($arr[0])] = trim($arr[1]);
    }

    # Метод добавляет в индексный массив одно значение.
    protected function appendIndexes($line)
    {
        # На каждой строке берем только первое слово
        $line = trim($line);
        $arr = explode(" ", $line);
        array_push(static::$indexes, trim($arr[0]));
    }

    # Метод возвращает значение ключа в словаре. Если такого ключа в словаре нет, возвращается пустое значение.
    # Под словарем здесь подразумевается просто структура данных
    protected function getDictValue($dict, $key)
    {
        if(isset($dict[$key])){
            return $dict[$key];
        } else {
            return null;
        }
    }

    # Метод проверяет слово на существование, и возвращает либо True, либо False.
    # Для того, чтобы понять, существует ли слово, проверяется индексный массив(там хранится весь список слов данной части речи).
    protected function isDefined($word)
    {
        if(in_array($word, static::$indexes)) return true;

        return false;
    }

    # Метод возвращает лемму(нормализованную форму слова)
    public function getLemma($word)
    {
        $word = strtolower(trim($word));

		# Пустое слово возвращаем обратно
        if($word == '') return null;

		# Пройдемся по кэшу, возможно слово уже нормализовывалось раньше и результат сохранился в кэше
        $lemma = static::getDictValue(static::$cacheWords, $word);
        if($lemma) return $lemma;

		# Пройдемся по исключениям, если слово из исключений, вернем его нормализованную форму
        $lemma = static::getDictValue(static::$exceptions, $word);
        if($lemma) return $lemma;

        # Проверим, если слово уже в нормализованном виде, вернем его же
        if(static::isDefined($word)) return $word;

		# На этом шаге понимаем, что слово не является исключением и оно не нормализовано, значит начинаем нормализовывать его по правилам.
        $lemma = static::ruleNormalization($word);
        if($lemma){
            static::$cacheWords[$word] = $lemma; # Предварительно добавим нормализованное слово в кэш
            return $lemma;
        }

        return null;
    }

	# Нормализация слова по правилам (согласно грамматическим правилам, слово приводится к нормальной форме)
    protected function ruleNormalization($word)
    {
        # Бежим по всем правилам, смотрим совпадает ли окончание слова с каким либо правилом, если совпадает, то заменяем окончние.
        foreach (static::$rule as $item) {
            $suff = $item[0];
            if(static::endsWith($word, $suff)){
                $lemma = $word; # Копируем во временную переменную
                $lemma = \Str::beforeLast($lemma, $suff); # Отрезаем старое окончание
                $lemma .= $item[1]; # Приклеиваем новое окончание
                if(static::isDefined($lemma)) return $lemma; # Проверим, что получившееся новое слово имеет право на существование, и если это так, то вернем его
            }
        }
        return null;
    }

    public static function endsWith($word, $suff){
        $start = \Str::beforeLast($word, $suff);
        if($start . $suff === $word) return true;
        return false;
    }
}
