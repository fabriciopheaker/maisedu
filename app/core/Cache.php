<?php

namespace core;


class Cache {

    private $file;
    public function __construct($file_path){
        $this->file = CACHE_PATH."/$file_path";
    }

    public function save(array $array){
        $json = serialize($array);
        $file = fopen($this->file,'w+');
        fwrite($file,$json);
        fclose($file);
    }

    public function load(){
        if($this->fileExists()){
            $content = file_get_contents($this->file);
            return unserialize($content);
        }
        return false;
    }

    public function fileExists(){
        return file_exists($this->file);
    }

    public function getFilePath(){
        return $this->file;
    }
}