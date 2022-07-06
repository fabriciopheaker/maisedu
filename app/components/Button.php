<?php

namespace components;

use core\Action;
use core\Components;
use core\interfaces\Bootstrap;
use core\Script;

class Button extends Components implements Bootstrap{
    private static $modal = false;
    protected $icone_button;
    protected $label_button;
    protected $class;
    public $action;
    private static $id_modal = "button_confirmation_modal";
    /**
     * Undocumented function
     *
     * @param Action $action
     * @param string $icone_button
     * @param string $label_button
     * @param string $class_button
     */
    public function __construct(Action $action, $icone_button=null,$label_button ="", $class_button=""){
        $this->action = $action;
        $this->icone_button = $icone_button;
        $this->label_button = $label_button;
        $this->class = $class_button;
        self::$modal = true;

    }

    public function createComponent(){
        $label = (!empty($this->label_button)?" $this->label_button":"");
        $class = (!empty($this->class)?" $this->class":"");
        $button = "<button type='button' class='btn$class'";
        foreach($this->__variaveis as $key => $value){
            $button.=" $key='$value'";
        }
        $button.=" ".$this->action->onclick();
        $button.=">".((!empty($this->icone_button))?"<i class='$this->icone_button'></i>":"");

        $button.=$label."</button>\n";
        return $button;
    }
    
    public function show(){
       echo $this->createComponent();
    }
}