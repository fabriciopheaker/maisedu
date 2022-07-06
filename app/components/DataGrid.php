<?php

namespace components;

use core\Action;
use core\Model;
use core\Request;
use core\interfaces\AutomaticDataGrid;


class DataGrid extends \core\Components{
    const PAGINATOR_BGCOLOR_SELECTED = 'bg-primary';
    /**
     * Número máximo de registros por página
     *
     * @var int
     */
    protected $number_records_page; 
    /**
     * Array com os valores a ser exibidos ou uma classe/objeto do tipo 
     * AutomaticDataGrid para criar um paginator integrado ao banco de dados.
     *
     * @var array|\core\interfaces\AutomaticDataGrid;
     */
    protected $data;
    /**
     * prefixo para ser usado nas variávies do DataGrid.
     *
     * @var string
     */
    protected $form_name="data_table";
    /**
     * responsável pelo cabeçalho do DataGrid. Se estiver null ele usa o 
     * cabeçalho do $data
     *
     * @var array|null
     */
    protected $header;
    /**
     * Pega as requesições do sistema.
     *
     * @var Request
     */
    protected $request;

    protected $pag;


    protected $columns_action = [];
    protected $buttons_action = [];

    /**
     * Undocumented function
     *
     * @param [type] $title
     * @param array $header
     * @param [type] $model
     * @param integer $n_register_pg
     * @param string $form_name
     */
    public function __construct($data, array $header = null, $number_records_page = null, $title=""){
        $this->data = $data;
        $this->header = $header;
        $this->number_records_page = $number_records_page;
        $this->title = $title;
        $this->search = false;
        parent::__construct('datagrid.php');
    }

    public function setPagination($number_records_page){
        $this->number_records_page = $number_records_page;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setHeader(array $header){
        $this->header = $header;
    }

    public function setFormName($form_name){
        $this->form_name = $form_name;
    }

    public function addSearch(bool $search = true){
        $this->search = $search;
    }
    
    public function show(){
        $this->request                = Request::getRequest();
        $this->pagination       = "";
        
        $data = $this->prepareData();
        if($this->header){
            $this->thead        = $this->createTheader($this->header);
            $this->tbody        = $this->createTbody(array_keys($this->header), $data);
        }else if($this->total_records){
            $this->thead        = $this->createTheader(array_keys($data[0]->getData()));
            $this->tbody        = $this->createTbody(array_keys($data[0]->getData()), $data);
        }
        if(isset($this->number_records_page)){
            $this->pagination   = $this->createPagination();
        }

        if($this->search){
            $search_name  = $this->form_name."_search";
            $page_name  = $this->form_name."_pag";
            $action = $this->request->getAction();
            $action->$page_name = 1;
            unset($action->$search_name);
            $this->search_action = URL;
            $this->search_additiona_parameters = $action->getInputParameters();
            $this->search_name = $search_name;
            $this->search_value = $this->request->input($search_name,"");
        }
        $this->data;
        return parent::show();

    }
    private function tratePages(){
        $this->total_pages   = ceil($this->total_records/$this->number_records_page);
        if($this->total_pages<1){
            $this->total_pages = 1;
        }
        $page  = $this->request->input($this->form_name."_pg",1);   
        if($page<1){
            $page = 1;
        }else if($page>$this->total_pages){
            $page = $this->total_pages;
        }
        $this->page = $page;

    }
    private function prepareData(){
        $data = $this->data;
        if(is_array($data)){
            if(isset($this->number_records_page)){
                $this->search = false;
                $this->total_records = count($this->data);
                $this->tratePages();
                $inicio     = ($this->page-1)*$this->number_records_page;
                $data       = array_splice($data,$inicio,$this->number_records_page);
            }
            return $data;
        }        
        if(is_string($data)){
            $data    = new $data();            
        }

        if($data instanceof AutomaticDataGrid){
            $header = "*";
            if(isset($this->header))
            {
                $header = array_keys($this->header);
            }
            $form_request = $this->form_name."_search";
            $search = ($this->search)?$this->request->$form_request:null;
            $this->total_records = $data->countDataGrid($search);
            $this->tratePages();
            $limit = null;  
            if(isset($this->number_records_page)){
                $inicio = ($this->page-1)*$this->number_records_page;
                $limit = [$inicio,$this->number_records_page];
            }
            
            $data = $data->getDataGrid($header, $limit, $search);
            return $data;

        }

        throw new \Exception("Campo data invalido!");

    }

    private function createTheader(array $theaders = null){
        $thead = "";
        if(isset($theaders)){
            $thead = "<thead>\n\t<tr>\n";
            foreach($theaders as $value){
                $thead.="\t\t<th>$value</th>\n"; 
            }
            if(count($this->buttons_action)){
                $thead.="\t\t<th>Ações</th>\n"; 
            }
            $thead.= "\t</tr>\n</thead>\n";
       }
       return $thead;
        
    }

    private function createTbody(array $headers, array $data)
    {
        $body ="";
        if(count($data)){
            foreach($data as $obj){
                $body.="<tr>";
                foreach($headers as $header){
                    $column = $obj->$header;
                    if(array_key_exists($header,$this->columns_action)){
                        $parameters = $this->columns_action[$header]['parameters'];
                        $action     =  $this->columns_action[$header]['action'];
                        foreach($parameters as $key => $param){
                            $action->$key = $obj->$param;
                        }
                        $column = "<a href='".$action->getUrl()."'>$column</a>";   
                    }
                    $body.="<td>".$column."</td>";
                }
                $body.=$this->getActions($obj);
                $body.="</tr>\n";
            }
        }else{
            $n_header = count($headers);
            $colspan = "";
            if($n_header){
                $colspan = " colspan='$n_header' ";
            }
            $body = "<tr><td$colspan class='text-center'>Nenhum registro encontrado!</td></tr>\n";
            
        }
        return $body;
    }

    private function createPagination(){
        $total = ceil($this->total_records/$this->number_records_page);
        $html ="";
        $name_page          = $this->form_name."_pg";
        $this->name_page    = $name_page;
        $request            = Request::getRequest();
        $html              .="<div class='m-0 float-left text-gray'>Página $this->page de $total</div>";
        $action             = $request->getAction();
        $action->$name_page = 1;
        $link               = $action->getUrl();
        $disabled           = "";
        $html              .= '<ul class="pagination pagination-sm m-0 float-right">';
        if($this->page == 1){
            $disabled = 'disabled';
            $link="#";
        }
        $html.="<li class='page-item $disabled'><a class='page-link' href='$link'>&laquo;</a></li>";
        for($x = 1; $x<=$total; $x++){
            $selected = "";
            if($x==$this->page){
                $selected = self::PAGINATOR_BGCOLOR_SELECTED;
                $link="#";
            }else{
                $action->$name_page = $x;
                $link = $action->getUrl();
            }
            $html.="<li class='page-item'><a class='page-link $selected' href='$link'>$x</a></li>";
        }
        $disabled = "";
        $action->$name_page = $total;
        if($this->page == $total){
            $disabled = 'disabled';
            $link="#";
        }
        $html.="<li class='page-item  $disabled'><a class='page-link' href='$link'>&raquo;</a></li>";
        $html.="</ul>";
        return $html;
    }
    
    
    /**
         * Transforma uma coluna do datagrid em um link;
         *
         * @param string $column  nome da coluna que será convertida. use o nome do key do parâmetro data 
         * @param Action $action objeto da classe Action com a página que deve ser chamada.
         * @param array $action_parameters parametros que devem ser subistituidos no action ex.: 'codigo'=>'cod_user' o action vai receber
         *  o valor do coduser do objeto que foi passado com o rotulo de codigo.
         * @return void
         */
        public function convertColumnInLink($column,Action $action,array $action_parameters=[]){
            $this->columns_action[$column] = ['action'=>$action,'parameters'=>$action_parameters];
        }


        public function addButtonInActionColumn(Button $button,array $action_parameters=[]){
            $this->buttons_action[] = ['button'=>$button,'parameters'=>$action_parameters];
        }

        private function getActions($obj){
            $html = "<td style='width:15%;'>";
            foreach($this->buttons_action as $btnaction){
                /**
                 * @var Button $btnaction['button'] 
                 */
                foreach($btnaction['parameters'] as $key => $keyobj){
                    $btnaction['button']->action->$key = $obj->$keyobj;    
                }
                $html .=  $btnaction['button']->createComponent();
            }
            return $html."</td>";
        }
        




    
}