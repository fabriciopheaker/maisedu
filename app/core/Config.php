<?php


namespace core;

class Config{
    private function __construct(){}
    private static $vars = [];

    /**
     * Retorna um arquivo de configuração da pasta config no formato de variável.
     *
     * @param [string] $filename
     * @return array
     */
    public static function get(string $filename){
        $ext = substr($filename,strlen($filename)-4);
        if($ext == '.php'){
            $filename = str_replace($ext,'',$filename);
        }
        $chave =  str_replace(" ",'_',$filename);

        if(array_key_exists($chave,self::$vars)){
            return self::$vars[$chave];
        }
        $filename = CONFIGS_PATH.'/'.$filename.'.php';
        if(!file_exists($filename)){
            throw new \Exception("O arquivo $filename não existe!");
        }

        return include $filename;
    }
}