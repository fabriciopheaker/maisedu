<?php

namespace core;

class Action {
    private $controller;
    private $method;
    private $parameters;
    private const METHOD_DEFAULT = 'index';


    public function __construct($controller = null, $method = self::METHOD_DEFAULT, array $parameters = []){
        $this->controller = $controller;
        $this->method = $method;
        $this->parameters = $parameters;
    }

    public static function get($controller = null, $method = self::METHOD_DEFAULT, array $parameters = []){
        return new Action($controller,$method,$parameters);
    }

    public function addParameter($name,$value){
        $this->parameters[$name] =$value;
    }
    public function addParameters($data){
        $this->parameters = array_merge($this->parameters,$data);
    }


    public function __get($name){
        if(array_key_exists($name,$this->parameters)){
            return $this->parameters[$name];
        }
        return null;
    }

    public function __set($name,$value){
        $this->parameters[$name] =$value;
    }

    public function __unset($name){
        unset($this->parameters[$name]);
    }

    public function getUrl(){
        //empty null ou quando o valor for "";
        $parameters = $this->parameters;
        if(!empty($this->controller)&&$this->controller!=HOMEPAGE){
            $parameters['p'] = $this->controller;
        }

        if(!empty($this->method)&&$this->method!=Self::METHOD_DEFAULT){
            $parameters['a'] = $this->method;
        }
        $parameters = http_build_query($parameters);
    
        if(!empty($parameters)){
            $parameters="?$parameters";
        }
        return URL."/$parameters";
    }

    public function getInputParameters(){
        $html = "";
        foreach($this->parameters as $key => $param){
            $html.="<input type='hidden' name='$key' value='$param'/>\n";
        }
        return $html;
    }


    public function onclick(){
       return "onclick=\"window.location.href='".$this->getUrl()."'\"";
    }

    public function run(){
        $controller = "controllers\\".ucfirst($this->controller);
        $method = $this->method;
        try{
            $controller = new $controller();
            $controller->$method(Request::getRequest());
        }catch(\Exception $e){ 
            if(APPLICATION_ENV == 'development'){
                throw $e;
            }
            if(defined('PAGE_404')){
                (new Action(PAGE_404))->redirect();
            }
            die("<h1>Erro 404!</h1>");
        }

        

    }


    public  function redirect(){
        header("Location: ".$this->getUrl());
        exit;
    }
}