<?php 


namespace components;

use \core\Components;
use core\interfaces\AutomaticOptionsSelect;
use core\Script;
use core\Style;

class SelectFromModel extends Components{
    protected $data;
    protected $placeholder;
    protected $where;
    //public $value;
/**
 * Cria um select2 com base em Model do banco de dados, ou um array ['codigo'=>'valor'].
 * ATENÇÃO! o modelo deve possuir a interface 
 *
 * @param array|AutomaticOptionsSelect $data dados
 * @param string $value
 * @param string $placeholder placeholder do component no html
 * @param array $where ["Condição ex: where nome = :nome",['nome'=>"Fulano"]];
 * @param string $name name do component no html;
 * @param bool $required preechimento do component requerido true|false
 * @param string $html_class atributos do component na classe html.
 */
    public function __construct($data,$value=null,$placeholder=null,$where=null,$name=null,$required = false,$html_class = "form-control"){
        $this->data = $data;
        $this->placeholder;
        if(isset($placeholder)){
            //$html.="<option value=''>$this->prefix</option>";
            $nameplaceholder = 'data-placeholder';
            $allow = 'data-allow-clear';
            $this->$nameplaceholder = $placeholder;
            $this->$allow = "true";
            //data-placeholder="Select an option" data-allow-clear="true"
            
            
        }
        if(isset($name)){
            $this->name= $name; 
        }
        $this->where = $where;
        $this->value = $value;
        $this->class = $html_class;
        if($required){
            $this->required = null;
        }
        Style::addStyle('select2');
        Style::addStyle('select2-bootstrap');
    }

    public function show(){
        if(is_null($this->id)){
            $this->id=$this->name;
        }
        $this->style="width: 100%;";
        $this->class = "select2 select2-".COLOR_DEFAULT." $this->class";  
        $color ="data-dropdown-css-class";
        $this->$color="select2-".COLOR_DEFAULT;
        $html = "<select";
        foreach($this->__variaveis as $attr => $value){
            $html.=" $attr='$value'";
        }
        $html.=">";

        $html.=$this->generateOptions();
        $html.='</select>';
        $value = (is_null($this->value))?'null':$this->value;
        Script::addScriptFile('select2');
        Script::addScriptFile('select2-pt-BR');
        Script::addScript("
        $(document).ready(function(){
            $('.select2').select2({
                language:'pt-BR',
                theme: 'bootstrap4',
                
            });
            $('.select2').val($value).trigger('change');
        });");
        echo $html;
        

    }

    private function generateOptions() {
       $html = "";
       $data = $this->data;
        if(is_string($data)){
            $data = new $data();
        }

        if($data instanceof AutomaticOptionsSelect){
            $data = $data->getOptionsSelect($this->where);
        }


        if(is_array($data)){
            foreach($data as $value => $option){
                $html.="<option value='$value'>$option</option>";
            }
            return $html;

        }
       throw new \Exception("A variavél \$data possui um valor inválido.");
    }
}
