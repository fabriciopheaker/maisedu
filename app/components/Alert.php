<?php

namespace components;

use core\Components;

class Alert extends Components{
    const ALERT_WARNING = 'warning';
    const ALERT_DANGER = 'danger';
    const ALERT_INFO = 'info';
    const ALERT_SUCCESS = 'success';

    /**
     * Undocumented function
     *
     * @param Alert::ALERT_WARNING|Alert::ALERT_DANGER|Alert::ALERT_INFO|Alert::ALERT_SUCCESS $tipo
     * @param [type] $titulo
     * @param [type] $texto
     */
    public function __construct($tipo,$titulo,$texto){
        $this->tipo = $tipo;
        $this->titulo = $titulo;
        $this->texto = $texto;
        $this->icone = $this->getIcon($tipo);
        parent::__construct('alerte.php');
    }


    public function getIcon($tipo){
        switch($tipo){
            case self::ALERT_WARNING: 
                return 'exclamation-triangle';
            case self::ALERT_DANGER:
                return 'exclamation-circle';
            case self::ALERT_SUCCESS: 
                return 'check-circle';
            default:
                return 'info-circle';
        }
    }
    public function registerFlashMessage(){
        $session = \core\Session::getSession();
        $session->flash_message = $this;
    }



    public static function getFlashMessage(){
        $session = \core\Session::getSession();
        $mensagem = $session->flash_message;
        unset($session->flash_message); 
        if(!empty($mensagem)){
           $mensagem->show();
        }

    }


}