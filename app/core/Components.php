<?php

namespace core;

class Components{
    protected $view;
    protected $__variaveis = [];

    public function __construct($view){
        $this->view = VIEWS_PATH."/components/$view";
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

    public function show(){
        extract($this->__variaveis);
        require $this->view;
    }



    




}