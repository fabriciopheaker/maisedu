<?php


namespace controllers;

use components\Alert;
use core\View;
use middleware\Authenticated;
use models\Senha;

use \core\Request;
use \core\Action;
use \core\Session;
use \core\Controller;
use models\Usuario;

class Login extends Controller{

    protected $required_authentication = null;

    public function index(){
        new Authenticated(false);
        $view = new View('autenticacao/login.php','blank.php');
        $view->title = 'Login';
        $view->register = "";
        if(SELF_REGISTER){
            $view->register = "<p class='col'>\n<a href='".
            Action::get('Cadastrar',)->getUrl()
            ."' class='text-center'>Quero me registrar</a>\n</p>";
        }
        $view->show();
    }
   
    public function logar(Request $request){
        new Authenticated(false);
        if(is_null($request->login)||is_null($request->password)){
            $this->flashMessage('Dados em branco!', 'O login e senha são requeridos.',Alert::ALERT_DANGER);
            Action::get('Login')->redirect();
        }
        if(!$this->session->authenticate($request->login,$request->password)){
            $this->flashMessage('Dados inválidos!', 'O login ou senha não conferem.',Alert::ALERT_DANGER);
            Action::get('Login')->redirect();
        }
        Action::get()->redirect();
        
    }

    public function logout(){
        new Authenticated(true);
        $this->session->logout();
        Action::get('Login')->redirect();
    }

  
}