<?php 


namespace controllers;

use core\Controller;
use core\Request;
use middleware\Authenticated;
use components\Alert;
use core\Action;
use core\View;
use models\Grupo;
use models\Usuario;

class Cadastrar extends Controller{
    

    public function __construct(){
        new Authenticated(false);
        if(!SELF_REGISTER){
           Action::get('Login')->redirect();
        }
    }
    public function cadastrar(Request $request){
        if(empty($request->nome)||empty($request->email)||empty($request->password)){
          $this->goBackError('Dados incompletos!',
          "O nome, e-mail, senha e confirmação de senha são obrigatórios!");
        }
        if($request->password != $request->confirme_password){
            $this->goBackError('Erro de cadastro!', 
            "Senha e Confirmação de senha não são iguais.");
        }
        $email = $request->email.'@estudante.ifto.edu.br';
        $grupo_descricao = 'Alunos';
        if($request->grupo=='Servidores'){
            $email = $request->email.'@ifto.edu.br';
            $grupo_descricao = 'Servidores';
        }
        
        $grupo = new Grupo(null,$grupo_descricao);
        $user = new Usuario();
        try{ 
        $user->save(['login'=>$email, 
                     'password'=>$request->password, 
                     'nome'=>$request->nome,
                     'grupos'=>[$grupo->cod_grupo],
                     ]
                 );
        }catch(\Exception $e){
            $this->goBackError('Erro ao registrar o cadastro',$e->getMessage());
        }
        $mensagem = new Alert(alert::ALERT_SUCCESS,"$email cadastrado com sucesso", 
        "Nós enviamos um e-mail de confirmação para você!");
        $mensagem->registerFlashMessage();
        Action::get('Login')->redirect();
        
    }

    private function goBackError($titulo, $mensagem){
        $mensagem = new Alert(alert::ALERT_DANGER,$titulo, $mensagem);
        $mensagem->registerFlashMessage();
        Action::get('Cadastrar')->redirect();
    }

    public function index(){
        $view = new View('autenticacao/registro.php','blank.php');
        $view->show();
    }
}