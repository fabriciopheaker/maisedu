<?php

namespace controllers;

use components\ButtonConfirmationModal;
use components\Menu;
use core\Action;
use core\Controller;
use core\View;
use core\Style;
use models\Modulo;

class Home extends Controller{
    public function index(){
        $nome = $this->session->user->getPessoa()->nome;
        $view = new View('home.php');
        $view->title = "Início";
        $view->button = new ButtonConfirmationModal(new Action('Teste'), 'fas fa-edit','(editar)','bg-navy',
            'Deseja mesmo editar?',"$nome, você vai mesmo fazer isso?",
        'Fazer mesmo assim');
        $view->button2 = new ButtonConfirmationModal(new Action('Teste'),'fas fa-trash','(excluir)','btn-danger',
            'Deseja mesmo editar?','Joaquim, você vai mesmo fazer isso?',
        'Fazer mesmo assim',ButtonConfirmationModal::DANGER);
        $view->show();
    }
}