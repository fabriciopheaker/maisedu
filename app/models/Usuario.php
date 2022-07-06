<?php

namespace models;
use \core\Model;
use \core\interfaces\UserAuthenticate;
class Usuario extends Model implements UserAuthenticate{

    protected $pk = 'cod_usuario';
    protected $table = 'usuario';
    protected $connection = 'default';
    private $grupos;
    private $pessoa;
    public $menu;
    private $modulos_com_privilegio;

    /**carrega os privilegios do usuário no model Modulo */
    private function loadPrivilegios(){
        if(is_null($this->modulos_com_privilegio) && !empty($this->cod_usuario)){
            $modulos = new Modulo();
            $this->modulos_com_privilegio = [];
            $privilegios = $modulos->getModulosUsuario($this->cod_usuario);
            foreach($privilegios as $privilegio){
                $this->modulos_com_privilegio[$privilegio->cod_modulo] 
                    = $privilegio;
            }
        }
    }


    public function checkPrivilegio($cod_modulo){
        $this->loadPrivilegios();
        if(array_key_exists($cod_modulo,$this->modulos_com_privilegio)){
            return true;
        }
        return false;
    }

    public function checkLogin(string $login){
        $result = $this->find('cod_usuario',
        [
            'login = :login',
            ['login'=>$login]
        ]);
        return ($result)?$result->cod_usuario:false;
    }

    public function save($data = null){
        if(is_null($data)){
            $data = $this->getData();
        }
        if(array_key_exists('login',$data)){
            //verificar se o login existe na base;
            $cod_usuario = $this->checkLogin($data['login']);
            if($cod_usuario){
                if($cod_usuario!=$this->cod_usuario){
                    throw new \Exception($data['login']." Já cadastrado no sistema.");
                }
            }
        }
        $data = $this->savePessoa($data);
        if(array_key_exists('grupos',$data)){
            $grupos = $data['grupos'];
            unset($data['grupos']);
        }

        if(array_key_exists('password',$data)){
            $data['password'] = md5($data['password']);
        }
        parent::save($data);
        $this->saveGrupos($grupos);

    }
    /**
     * Manipulando os grupos do usuário;
     */

    public function saveGrupos(array $newgrupos){
        $gruposuser = new UsuarioGrupo();
        
        $gruposuser->deleteGroupsNotIn($this->cod_usuario,$newgrupos);
        $this->loadGrupos();
        foreach($this->grupos as $grupo){
            $pos_grupo =-1;
            foreach($newgrupos as $key => $novogrupo){
                if($novogrupo == $grupo->cod_grupo){
                    $pos_grupo = $key;
                    break;
                }
            }
            if($pos_grupo > -1){
                unset($newgrupos[$pos_grupo]);
                $pos_grupo = -1;
            }
        }
        foreach($newgrupos as $grupo){
            $gruposuser = new UsuarioGrupo();
            $gruposuser->save(['cod_usuario'=>$this->cod_usuario, 'cod_grupo'=>$grupo]);
        }
        $this->loadGrupos();
        
    }

    private function loadGrupos(){
        $gruposuser = new UsuarioGrupo();
        $this->grupos = $gruposuser->getGruposUsuario($this->cod_usuario);
    }

/*************************** Cuida da parte da base pessoa. */
    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public function getPessoa(){
        if(is_null($this->pessoa)&&$this->cod_pessoa){
            $this->pessoa = new Pessoa($this->cod_pessoa);
            if(is_null($this->pessoa->cod_pessoa)){
                throw new \Exception("Falha ao carregar dados pessoais!");
            }
        }
        return $this->pessoa;
    }
    private function savePessoa($data){
         $pessoa = new Pessoa();
         $colunas = $pessoa->showColumns();
         $datapessoa = [];
         foreach($colunas as $coluna){
             $field = $coluna['Field'];
             if(array_key_exists($field,$data)){
                $datapessoa[$field] = $data[$field];
                unset($data[$field]);
             }
         }
         if(array_key_exists('cod_pessoa',$datapessoa)){
             $pessoa = new Pessoa($datapessoa['cod_pessoa']);
         }
         $pessoa->save($datapessoa);
         $data['cod_pessoa'] = $pessoa->cod_pessoa;
         return $data;
    }

    public function authenticate($user,$password){
        $query = 'login=:login AND password=md5(:password)';
        $values = ['login'=>$user,'password'=>$password];
        $usuario = $this->find('cod_usuario, cod_pessoa, login, token',[$query,$values]);
        if($usuario){
            $usuario->getPessoa();
            
        }
        return $usuario;
    }


    public function logout(){
    }
}