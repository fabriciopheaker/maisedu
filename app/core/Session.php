<?php

namespace core;

use core\interfaces\UserAuthenticate;

class Session{
    private static $instance;
    private function __construct(){
        session_start();
    }

    public static function getSession(){
        if(is_null(self::$instance)){
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function __invoke(){
        if(is_null(self::$instance)){
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function __set($name,$value){
        $array = unserialize($_SESSION[SESSION_NAME]);
        $array[$name] = $value;
        $_SESSION[SESSION_NAME] = serialize($array);
    }

    public function __get($name){
        $array = unserialize($_SESSION[SESSION_NAME]);
        return (is_array($array)&&array_key_exists($name,$array))?$array[$name]:null;
    }

    public function __unset($name){
        $array = unserialize($_SESSION[SESSION_NAME]);
        unset($array[$name]);
        $_SESSION[SESSION_NAME] = serialize($array);
    }

    public function __isset($name){
        $name = $this->__get($name);
        return isset($name);
    }

    public function authenticate($user,$password,$model = MODEL_AUTHENTICATE){
        if(is_string($model)){
            $model = new $model();
        }
        if($model instanceof UserAuthenticate){
            $usuario = $model->authenticate($user,$password);
            if($usuario){
                $this->user = $usuario;
                return true;
            }
            return false;
        }
        $model = get_class($model);
        new \Exception("O model $model precisa ser uma instância da interface UserAuthenticate");
    }
    
    public function logout(){
        if(isset($this->user)){
            $this->user->logout();  
            unset($_SESSION[SESSION_NAME]);
        }

       
    }
}