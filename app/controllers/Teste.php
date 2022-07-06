<?php 

namespace controllers;

use core\Controller;
use core\Request;
use core\View;

class Teste extends Controller{
    public function index(Request $request){
        $view = new View('patricia.php');
        $colega = $request->colega;
        var_dump($colega);
        $view->frase = "";
        if($colega){
            $view->frase = "Você fez o trabalho com o ".$colega."?";
        }
        $view->show();
    }

}
