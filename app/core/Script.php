<?php

namespace core;

class Script{
    private static $scripts = [];
    private static $bloco = "";
    private function __construct(){}
    public static function addScriptFile($scriptname){
        /**
         * @var array $scripts
         */
        $scripts = Config::get('scripts');
        if(!array_key_exists($scriptname, $scripts)){
            throw new \Exception('Script não está presente no arquivo de configuração scripts.php');
        }
        self::$scripts[$scriptname] = true;
          
    }

    public static function addScript($text){
        self::$bloco .= $text;
    }

    public static function show(){
        if(count(self::$scripts)){
            foreach(Config::get('scripts') as $key => $scrypt){
                if(array_key_exists($key,self::$scripts)){
                    echo '<script src="'.URL.'/'.$scrypt.'"></script>'."\n";
                    unset(self::$scripts[$key]); 
                    if(!count(self::$scripts)){
                        break;
                    }
                }
                
            }
        }
        if(!empty(self::$bloco)){
            echo "<script>\n\t".self::$bloco."\n</script>\n";
        }
        return;
    }
}