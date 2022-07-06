<?php

namespace components;

use core\Action;
use core\Script;

class ButtonConfirmationModal extends Button{
    private static $modal = false;
    private static $id_modal = "button_confirmation_modal";
    public function __construct(Action $action, $icone_button=null,$label_button ="",$class_button="",$modal_title=null,$modal_text=null,$modal_btn_confirme=null,$modal_color = null){
        $this->action = $action;
        $this->icone_button = $icone_button;
        $this->label_button = $label_button;
        $this->class = $class_button;
        if(isset($modal_title)){
            $this->modal_title = $modal_title;
        }
        if(isset($modal_text)){
            $this->modal_text = $modal_text;
        }
        if(isset($modal_btn_confirme)){
            $this->modal_btn_confirme = $modal_btn_confirme;
        }
        
        if(isset($modal_color)){
            $this->modal_color = $modal_color;
        }
        $this->setParametersModal();
        self::$modal = true;

    }

    private function setParametersModal(){
        $this->__variaveis['data-toggle'] = 'modal';
        $this->__variaveis['data-target'] = "#".self::$id_modal;
    }

    public function createComponent(){

        $label = (!empty($this->label_button)?" $this->label_button":"");
        $class = (!empty($this->class)?" $this->class":"");
        $this->__variaveis['action'] = $this->action->getUrl();
        $button = "<button type='button' class='ConfirmationModal btn$class'";
        foreach($this->__variaveis as $key => $value){
            $button.=" $key='$value'";
        }
        $button.=">".((!empty($this->icone_button))?"<i class='$this->icone_button'></i>":"");
        $button.=$label."</button>\n";
        Script::addScriptFile('ButtonConfirmationModal');
        return $button;
    }

    //* inclue modal ao template. 
    public static function getModal(){
        $id = self::$id_modal;
        $color_default = COLOR_DEFAULT;
        if(self::$modal){
            include(VIEWS_PATH.'/components/alertmodal.php');
        }
        return "";
    }
}