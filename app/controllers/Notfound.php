<?php

namespace controllers;
use core\Controller;
use core\View;
use models\Senha;
class Notfound extends Controller{
    public function index(){
        $view = new View('404.html');
        $view->title = "404";
        $view->show();
    }
}