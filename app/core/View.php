<?php

namespace core;

use components\Menu;

class View{
    protected $view;
    protected $template;
    protected $__variaveis = [];

    public function __construct($view, $template=DEFAULT_TEMPLATE){
        $this->controller = Request::getRequest()->getController();
        $this->template = $template;
        $this->view = VIEWS_PATH."/$view";
        $this->olds = $this->getOlds();
    }


    public function getOlds(){
        $session = Session::getSession();
        if(isset($session->olds)){
           return $session->olds;
        }
        return [];
    }
    
    public function __set($name, $value)
    {
        $this->__variaveis[$name] = $value;
    }

    public function __get($name){
        if(array_key_exists($name, $this->__variaveis)){
            return $this->__variaveis[$name];
        }
        return null;
    }

    public function addArray(array $array){
        $this->__variaveis = array_merge($this->__variaveis, $array);
    }

    public function get($name, $default="",$old=true){
        if(array_key_exists($name,$this->__variaveis)){
            $default=$this->__variaveis[$name];
        }else if(array_key_exists($name,$this->olds) && $old){
            $default=$this->olds[$name];
        }
        return $default;
    }

    private function getComponent($class, $parameters = []){
        
        if(strpos($class,'components')===false){
            $class = '\\components\\'.$class;
        }
        $class = new \ReflectionClass($class);
        return $class->newInstanceArgs($parameters);
    }


    public function show(){
        extract($this->__variaveis);
        $view = $this->view;
        $get = function($name, $default="",$old=true){
            return $this->get($name, $default,$old);
        };
        $echo = function($name,$default="",$old=true){
            echo $this->get($name,$default,$old);
        };
        $component = function($class,$parameters = []){
            return $this->getComponent($class,$parameters);
        };

        $value = function($name,$default="",$old=true){
            echo " value='".$this->get($name,$default,$old)."'";
        };
        require TEMPLATES_PATH."/$this->template";
    }



    




}