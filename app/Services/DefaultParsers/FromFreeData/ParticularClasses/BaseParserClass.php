<?php


namespace App\Services\DefaultParsers\FromFreeData\ParticularClasses;


use App\Services\DefaultParsers\FromWordFrequencyData\ImportsFromXLSX\LemmasFirstSheetImport;

abstract class BaseParserClass
{
    protected $limit;
    protected $path;
    protected $table;
    protected $pos;

    public function __construct($path = '', $table = '', $pos = 'n', $limit = 500)
    {
        if(file_exists($path)){
            $this->path = $path;
        }
        if(\Schema::hasTable(strtolower($table))){
            $this->table = $table;
        }
        $this->pos = LemmasFirstSheetImport::PARTS_OF_SPEECH[$pos];
        $this->limit = $limit;
    }

    public function changeField($field = 'none', $value = null)
    {
        if(isset($this->{$field})){
            $this->{$field} = $value;
        }
        return $this;
    }

    public function read()
    {
        if($this->path && $this->table){
            $res = [];
            try{
                $f = fopen($this->path, 'r');
                if ($f) {
                    while(($line = fgets($f)) !== false) {
                        $cur = $this->handler($line);
                        if($cur){
                            array_push($res, $cur);
                            if(count($res) >= $this->limit){
                                \DB::table($this->table)->insertOrIgnore($res);
                                $res = [];
                            }
                        }
                    }
                    \DB::table($this->table)->insertOrIgnore($res);
                    fclose($f);
                }
            } catch (\Exception $e){
                throw new \Exception('File does not load');
            }
        }
    }

    abstract public function handler($line = null);
}
