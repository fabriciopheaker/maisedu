<?php

namespace core;

class Style{
    private static $styles = [];
    private function __construct(){}
    public static function addStyle($stylename){
        $styles = Config::get('styles');
        if(!array_key_exists($stylename, $styles)){
            throw new \Exception('Estilo não está presente no arquivo de configuração styles.php');
        }
        self::$styles[$stylename] = true;
          
    }

    public static function show(){
        if(count(self::$styles)){
            foreach(Config::get('styles') as $key => $style){
                if(array_key_exists($key,self::$styles)){
                    echo '<link rel="stylesheet" href="'.URL.'/'.$style.'">'."\n";
                    unset(self::$styles[$key]);
                    if(!count(self::$styles)){
                        return;
                    }
                }
               
                
            }
        }
        return;
    }
}