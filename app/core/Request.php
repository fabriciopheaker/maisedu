<?php


namespace core;

class Request{
    /**
     * Exclui dados da requisição
     */
    const EXCLUDED = ['p','a','PHPSESSID'];
    private static $request;
    private function __construct(){
        $session = Session::getSession();
       if($_SERVER['REQUEST_METHOD']=='POST'){
           $request = md5(implode($_POST));
           if($session->request_key==$request)
            {
                $session->last_page->redirect();
            }
            $session->request_key = $request;
        }
        $session->last_page = $session->current_page;
        $session->current_page = $this->getAction();
       
    }

    /**
     * Retorna a instancia do metodo request.
     *
     * @return Request;
     */
    public static function getRequest(){
        if(is_null(self::$request)){
            self::$request = new Request();
        }
        return self::$request;

    }
    
    public function all(){
        return $_REQUEST;
    }
    public function getController(){
        return $this->input('p',HOMEPAGE);
    }
    public function getMethod(){
        return $this->input('a','index');
    }

    public function getData(){
        $all = $this->all();
        foreach(self::EXCLUDED as $exc){
            if(array_key_exists($exc,$all)){
                unset($all[$exc]);
            }
        }
        return $all;
    }
    public function input($name,$default=null){
        //(condição logica)?verdadeiro:false
        return (array_key_exists($name,$_REQUEST))?$_REQUEST[$name]:$default;
    }

    public function __get($name){
        return $this->input($name);
    }

    public function getAction(){
        $controller = $this->input('p',HOMEPAGE);
        $method     = $this->input('a','index');
        return new Action($controller,$method,$this->gets());
    }

    public function gets(){
        return $_GET;
    }

    //isset verifica se o valor existe retorna "" true;
    //empty verifica se o valor está em branco ele retora null e "" como true;

    public function __isset($name){
        $name = $this->input($name);
        return isset($name);
    }
}