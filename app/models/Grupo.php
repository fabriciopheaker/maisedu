<?php

namespace models;

use core\interfaces\AutomaticDataGrid;
use core\interfaces\AutomaticOptionsSelect;
use \core\Model;

class Grupo extends Model implements AutomaticOptionsSelect, AutomaticDataGrid{

    protected $pk = 'cod_grupo';
    protected $table = 'grupo';
    protected $connection = 'default';
    protected $modulos;

    public function __construct($id = null, $descricao = null){
        if(isset($descricao)&&is_null($id)){
            $query = "descricao=:descricao";
            $values = ['descricao'=>$descricao];
            parent::__construct(null,[$query,$values]);
        }else{
            parent::__construct($id);
        }
        
    }

    public function getOptionsSelect(array $where = null){
        $result = $this->findAll('cod_grupo, descricao ',$where,null,'descricao asc');
        $return = [];
        foreach($result as $object){
            $return[$object->cod_grupo] = "$object->descricao";
        }
        return $return;
    }

    public function getDataGrid($headers="*",$limit=null,$search=null){
        $where = null;
        if(isset($search)){
            $where =['descricao like :descricao',['descricao'=>"%$search%"]];
        }
        return $this->findAll($headers,$where,$limit);
    }


    public function countDataGrid($search = null){
        $where = null;
        if(isset($search)){
            $where =['descricao like :descricao',['descricao'=>"%$search%"]];
        }
        return $this->count($where);
    }


    public function save($data = null){
        if(is_null($data)){
            $data = $this->__data;
        }
        if(array_key_exists('descricao',$data)){
            if(empty($data['descricao'])){
                throw new \Exception("A descrição do grupo não pode ser vazia");
            }
            $grupo = new Grupo(null,$data['descricao']);
            if($grupo->cod_grupo != $this->cod_grupo){
                throw new \Exception("Já existe um grupo com essa descrição");
            }
        }
        if(array_key_exists('modulos',$data)){
            $modulos = $data['modulos'];
            unset($data['modulos']);
        }
        parent::save($data);
        if(isset($modulos)){
            $this->setModulos($modulos);
        }
    }

    private function loadModulos(){
        if(is_null($this->modulos) && isset($this->cod_grupo)){
            $this->modulos =  (new GrupoPrivilegio())->getModulosGrupo($this->cod_grupo);
        }
    }


    public function getModulos(){
        $this->loadModulos();
        return $this->modulos;
    }

    public function getCodModulos(){
        $modulos = $this->getModulos();
        $modulos = is_null($modulos)?[]:$modulos;
        $retorno = [];
        foreach($modulos as $modulo){
            $retorno[] = $modulo->cod_modulo;
        }
        return $retorno;

    }

    public function setModulos($modulos){
        
        if(count($modulos)){
            $first = array_key_first($modulos);
            if($modulos[$first] instanceof Modulo){
                $newarray = [];
                foreach($modulos as $modulo){
                    $newarray[] = $modulo->cod_modulo;
                }
                $modulos = $newarray;
            }
        }
        $privilegio = new GrupoPrivilegio();
        $privilegio->deleteModulosDoGrupo($this->cod_grupo,$modulos);
        foreach($this->getModulos() as $modulo){
            if(count($modulos)){
                foreach($modulos as $key => $newmodulo){
                    if($modulo->cod_modulo == $newmodulo){
                        unset($modulos[$key]);
                        break;
                    }
                }
            }else{
                break;
            }   
        }
        foreach($modulos as $modulo){
            $privilegio = new GrupoPrivilegio();
            $privilegio->save(['cod_modulo'=>$modulo, 'cod_grupo'=>$this->cod_grupo]);
        }
    }


    public function delete(){
        $privilegios = new GrupoPrivilegio();
        $privilegios->deleteModulosDoGrupo($this->cod_grupo,[]);
        $privilegios = new UsuarioGrupo();
        $privilegios->deleteUsersNotIn($this->cod_grupo,[]);
        parent::delete();
    }
}