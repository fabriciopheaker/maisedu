<?php 

namespace core;

class Connection{

    private static $database = null;
    private static $conn = null;

    private function __construct(){}


    public static function getConnection($db_name = 'default'){
        if($db_name != self::$database){
            $databases = Config::get('databases');
            if(array_key_exists($db_name,$databases)){
               $db = $databases[$db_name];
               $options = [];
               if($db['driver'] == 'mysql'){
                    $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
                    $db['port'] = (empty($db['port']))?3306:$db['port'];
               }
               $host = $db['driver'].':host='.$db['url'].';port='.$db['port'].
                            ';dbname='.$db['database'];
               try{ 
                    self::$conn = new \PDO($host,$db['user'],$db['password'],$options);
                    if(APPLICATION_ENV == 'development'){
                        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    }
                    self::$database = $db_name;
               }catch(\PDOException $e){
                    if(APPLICATION_ENV !='development'){
                        throw new \Exception("Não foi possível se connectar a base de dados.");
                    }
                    throw $e;
               }
               
            }else{
                throw new \Exception("$db_name não existe no arquivo ".CONFIGS_PATH.'/databases.php');
            }
        }

        return self::$conn;
        
        
    }
}