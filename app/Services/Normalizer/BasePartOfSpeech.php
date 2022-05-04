<?php


namespace App\Services\Normalizer;


class BasePartOfSpeech
{
    public $rule = []; # Правила замены окончаний при нормализации слова по правилам.
    public $exceptions = []; # Словарь исключений
    public $indexes = []; # Индексный массив
    public $exceptionsPath = ''; # Получим путь до файла исключений
    public $indexesPath = ''; # Получим путь до индексного словаря
    public $cacheWords = []; # Кэш

    public function __construct($pathDict, $excFile, $indexFile)
    {
        $this->exceptionsPath = storage_path($pathDict).$excFile;
        $this->indexesPath = storage_path($pathDict).$indexFile;

        $this->parseFile($this->exceptionsPath, "appendExceptions");
        $this->parseFile($this->indexesPath, "appendIndexes");
    }

    # Метод открывает файл на чтение, читает по одной строке и вызывает для каждой строки функцию, переданную в аргументе
    public function parseFile($file, $contentHandler)
    {
        try{
            $f = fopen($file, 'r');

            if ($f) {
                while(($line = fgets($f)) !== false) {
                    $this->{$contentHandler}($line);
                }
                fclose($f);
            }
        } catch (\Exception $e){
            throw new \Exception('File does not load');
        }
    }

    # Метод добавляет в словарь исключений одно значение.
    # Файл исключений представлен в формате: [слово-исключение][пробел][лемма]
    public function appendExceptions($line)
    {
        # При разборе строки из файла, каждую строку разделяем на 2 слова и заносим слова в словарь(первое слово - ключ, второе - значение). При этом не забываем убрать с концов пробелы
        $line = trim($line);
        $arr = explode(" ", $line);
        $this->exceptions[trim($arr[0])] = trim($arr[1]);
    }

    # Метод добавляет в индексный массив одно значение.
    public function appendIndexes($line)
    {
        # На каждой строке берем только первое слово
        $line = trim($line);
        $arr = explode(" ", $line);
        array_push($this->indexes, str_replace("_", "-", trim($arr[0])));
    }

    # Метод возвращает значение ключа в словаре. Если такого ключа в словаре нет, возвращается пустое значение.
    # Под словарем здесь подразумевается просто структура данных
    public function getDictValue($dict, $key)
    {
        if(isset($dict[$key])){
            return $dict[$key];
        } else {
            return null;
        }
    }

    # Метод проверяет слово на существование, и возвращает либо True, либо False.
    # Для того, чтобы понять, существует ли слово, проверяется индексный массив(там хранится весь список слов данной части речи).
    public function isDefined($word)
    {
        if(in_array($word, $this->indexes)) return true;

        return false;
    }

    # Метод возвращает лемму(нормализованную форму слова)
    public function getLemma($word)
    {
        $word = strtolower(trim($word));

		# Пустое слово возвращаем обратно
        if($word == '') return null;

		# Пройдемся по кэшу, возможно слово уже нормализовывалось раньше и результат сохранился в кэше
        $lemma = $this->getDictValue($this->cacheWords, $word);
        if($lemma) return $lemma;

		# Пройдемся по исключениям, если слово из исключений, вернем его нормализованную форму
        $lemma = $this->getDictValue($this->exceptions, $word);
        if($lemma) return $lemma;

        # Проверим, если слово уже в нормализованном виде, вернем его же
        if($this->isDefined($word)) return $word;

		# На этом шаге понимаем, что слово не является исключением и оно не нормализовано, значит начинаем нормализовывать его по правилам.
        $lemma = $this->ruleNormalization($word);
        if($lemma){
            $this->cacheWords[$word] = $lemma; # Предварительно добавим нормализованное слово в кэш
            return $lemma;
        }

        return null;
    }

	# Нормализация слова по правилам (согласно грамматическим правилам, слово приводится к нормальной форме)
    public function ruleNormalization($word)
    {
        # Бежим по всем правилам, смотрим совпадает ли окончание слова с каким либо правилом, если совпадает, то заменяем окончние.
        foreach ($this->rule as $item) {
            $suff = $item[0];
            if(static::endsWith($word, $suff)){
                $lemma = $word; # Копируем во временную переменную
                $lemma = \Str::beforeLast($lemma, $suff); # Отрезаем старое окончание
                $lemma .= $item[1]; # Приклеиваем новое окончание
                if($this->isDefined($lemma)) return $lemma; # Проверим, что получившееся новое слово имеет право на существование, и если это так, то вернем его
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
