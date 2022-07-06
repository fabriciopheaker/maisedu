<?php 


namespace components;

use \core\Components;
use core\interfaces\AutomaticOptionsSelect;
use core\Script;
use core\Style;

class ChecksFromModel extends Components{
    protected $data;
    protected $where;
    public $values;
    public $label;
    //public $value;
    /** 
     * Undocumented function
     *
     * @param array|AutomaticOptionsSelect $data se array passar ['value'=>'label']
     * @param string $name atributo name do component html
     * @param string $label mensagem para auxiliar o usuário no reconhecimento da informação
     * @param array $values um array que contem os códigos dos valores selecionados
     * @param array $where 1º posição query, 2 posição um vertor com os valores para subistituri
     */
    public function __construct($data,$name=null,$label=null,array $values = [],$where=null){
        $this->data = $data;
        if(isset($name)){
            $this->name= $name; 
        }
        $this->where = $where;
        $this->values = $values;
        $this->label = (is_null($label))?$name:$label;
    }

    public function show(){
        $html = "<div class='border-".COLOR_DEFAULT.
                 "' style='border:2px solid; padding:10px; border-radius:5px;".
                 "border-style:outset;' >
                    <label class='mb-3'>$this->label</label> ";
        $html.="<div class='row ml-2'>"; 
        $html.=$this->generateCheckBoxes();
        $html.="</div></div>";
        echo $html;
        

    }

    public function setValues(array $values){
        $this->values = $values;
    }

    private function generateCheckBoxes() {
       // <input class="custom-control-input custom-control-input-navy" type="checkbox" id="customCheckbox5" checked>
       //                     <label for="customCheckbox5" class="custom-control-label">Custom Checkbox with custom color outline</label>
        $html = "";
       $data = $this->data;
        if(is_string($data)){
            $data = new $data();
        }

        if($data instanceof AutomaticOptionsSelect){
            $data = $data->getOptionsSelect($this->where);
        }


        if(is_array($data)){
            $color = COLOR_DEFAULT;
            foreach($data as $value => $option){
                $checked = "";
                if(in_array($value,$this->values)){
                    $checked = ' checked';
                }
                $name = $this->name."[$value]";
                $id= "$this->names_$option";
                $html.="<div class='custom-control custom-checkbox col'>\n";
                $html.="\t<input class='custom-control-input custom-control-input-$color' type='checkbox' name='$name' id='$id'$checked>\n";
                $html.="\t<label for='$id' class='custom-control-label'>$option</label>\n";
                $html.="</div>\n";
            }
            return $html;

        }
       throw new \Exception("A variavél \$data possui um valor inválida.");
    }
}
