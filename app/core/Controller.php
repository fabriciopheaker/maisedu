<?php

namespace core;

use components\Alert;
use middleware\Authenticated;

class Controller{
/**
 * classe session que controla a sessão do sistema.
 *
 * @var Session
 */
    protected $session;
   /**
    * Verifica se o controller atual exige autenticação do usuário;
    * true -> só aceita usuário logados;
    * false -> só aceita usuários delogados, ou seja, usuários logados não podem ver a tela;
    * null -> tela pública qualquer pessoa pode utiliza-la usuário logado ou não.
    * @var boolean|NULL
    */
    protected $required_authentication = true;
    public function __construct(){
        $this->session = Session::getSession();
        if(!is_null($this->required_authentication)){
            new Authenticated($this->required_authentication);
        }

    }
/**
     * cria um Alert para o usuário
     *
     * 
     * @param [String] $titulo
     * @param [String] $texto
     * @param Alert::ALERT_WARNING|Alert::ALERT_DANGER|Alert::ALERT_INFO|Alert::ALERT_SUCCESS $tipo
     */
    public function flashMessage($titulo,$texto="",$tipo=Alert::ALERT_INFO){
        $mensagem = new Alert($tipo,$titulo, $texto);
        $mensagem->registerFlashMessage();
    }

    public function registerOld($data){
       $this->session->olds = $data;
    }

    
}