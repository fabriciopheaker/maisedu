<?php

namespace models;

use core\interfaces\AutomaticDataGrid;
use core\interfaces\AutomaticOptionsSelect;
use \core\Model;

class Modulo extends Model implements AutomaticDataGrid, AutomaticOptionsSelect{

    protected $pk = 'cod_modulo';
    protected $table = 'modulo';
    protected $connection = 'default';
    protected $grupos;
  


    public function getModulosUsuario($cod_usuario){
        $sql = "SELECT cod_modulo FROM modulo 
                        WHERE cod_modulo in 
                        (SELECT COD_MODULO FROM usuario_privilegio WHERE cod_usuario = :COD_USUARIO)
                        OR cod_modulo in 
                    (SELECT cod_modulo FROM grupo_privilegio gp 
                        inner join usuario_grupo ug ON gp.cod_grupo = ug.cod_grupo 
                        WHERE ug.cod_usuario = :COD_USUARIO)
                        ORDER BY cod_modulo asc;";
                return $this->query($sql,['COD_USUARIO'=>$cod_usuario])
                            ->fetchAll(\PDO::FETCH_CLASS, get_class($this));
    }

    public function getDataGrid($headers="*",$limit=null,$search=null){
        $where = null;
        if(isset($search)){
            $where =['menu like :menu OR descricao like :menu',['menu'=>"%$search%"]];
        }
        return $this->findAll($headers,$where,$limit);
    }


    public function countDataGrid($search = null){
        $where = null;
        if(isset($search)){
            $where =['menu like :menu OR descricao like :menu',['menu'=>"%$search%"]];
        }
        return $this->count($where);
    }

    /**
     * Undocumented function
     *
     * @param array|null $where
     * @return array
     */
    public function getOptionsSelect(array $where = null){
        $result = $this->findAll('cod_modulo, menu ',$where,null,'menu asc');
        $return = [];
        foreach($result as $object){
            $return[$object->cod_modulo] = "$object->menu";
        }
        return $return;
    }

    public function delete(){
        $privilegio = new GrupoPrivilegio();
        $privilegio->deleteGruposDoModulo($this->cod_modulo,[]);
        parent::delete();
    }
    public function save($data = null){
        if(is_null($data)){
            $data = $this->getData(); 
        }
        if(empty($data['menu']) || empty($data['descricao'])){
            throw new \Exception('O nome do módulo e a descrição são dados obrigatórios');
        }

        if(array_key_exists('cod_modulo_pai',$data) && $data['cod_modulo_pai']=='0'){
           $data['cod_modulo_pai'] = null;
        }
        
        if(array_key_exists('exclusivoadmin',$data) && $data['excluisvoadmin']!==false){
            $data['exclusivoadmin'] = true;
        }else{
            $data['exclusivoadmin'] = false;
        }

        if(array_key_exists('manutencao',$data) && $data['manutencao']!==false){
            $data['manutencao'] = true;
        }else{
            $data['manutencao'] = false;
        }

        if(array_key_exists('tipomodulo',$data)){
            switch($data['tipomodulo']){
                case 'url':
                    $data['controller'] = null;
                    $data['grupos'] = [];
                    break;
                case 'controller':
                    $data['url'] = null;
                    break;
                default:
                    $data['url'] = null;
                    $data['controller'] = null;
                    $data['grupos'] = [];
                    break;
            }
            unset($data['tipomodulo']);
        }
        if(array_key_exists('iconetype',$data)){
            unset($data['iconetype']);
        }
        if(array_key_exists('grupos',$data)){
            $grupos = $data['grupos'];
            unset($data['grupos']);
        }
        parent::save($data);
        if(isset($grupos)&&is_array($grupos))
        {
            $this->setGrupos($grupos);
        }
    }


    public function setGrupos(array $grupos){
        if(count($grupos)){
            $first = array_key_first($grupos);
            if($grupos[$first] instanceof Grupo){
                $newarray = [];
                foreach($grupos as $grupo){
                    $newarray[] = $grupo->cod_grupo;
                }
                $grupos = $newarray;
            }
        }
        $privilegio = new GrupoPrivilegio();
        $privilegio->deleteGruposDoModulo($this->cod_modulo,$grupos);
        foreach($this->getGrupos() as $grupo){
            if(count($grupos)){
                foreach($grupos as $key => $newgrupo){
                    if($grupo->cod_grupo == $newgrupo){
                        unset($grupos[$key]);
                        break;
                    }
                }
            }else{
                break;
            }   
        }
        foreach($grupos as $grupo){
            $privilegio = new GrupoPrivilegio();
            $privilegio->save(['cod_grupo'=>$grupo, 'cod_modulo'=>$this->cod_modulo]);
        }
    }

    private function loadGrupos(){
        if($this->cod_modulo){
            $privilegio = new GrupoPrivilegio();
            $this->grupos = $privilegio->getGruposModulo($this->cod_modulo);
        }
    }
    public function getGrupos(){
        if(is_null($this->grupos)){
            $this->loadGrupos();
        }
        return $this->grupos;
    }

    public function getCodGrupos(){
        $grupos = $this->getGrupos();
        $grupos = is_null($grupos)?[]:$grupos;
        $retgrupos = [];
        foreach($grupos as $grupo){
            $retgrupos[] = $grupo->cod_grupo;
        }
        return $retgrupos;

    }

    public function getData(){
        $data = parent::getData();
        if(isset($data['icone'])){
            $icone = explode(" ",$data['icone']);
            if(count($icone)==2){
               $data['iconetype'] = $icone[0];
               $data['iconename'] = str_replace("fa-","",$icone[1]);
            }
        }
        $data['grupos'] = $this->getGrupos();
        
        return $data;
    }

}