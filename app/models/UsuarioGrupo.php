<?php

namespace models;
use \core\Model;

class UsuarioGrupo extends Model{

    protected $pk = 'cod_usuario_grupo';
    protected $table = 'usuario_grupo';
    protected $connection = 'default';

    public function getGruposUsuario($cod_usuario){
        $query = 'cod_usuario=:cod_usuario';
        $values = ['cod_usuario'=>$cod_usuario];
        return $this->findAll("*",[$query,$values],null,'cod_grupo asc');
    }

    public function deleteGroupsNotIn($cod_usuario,array $grupos){
        $grupos = implode(', ',$grupos);
        $query = "DELETE FROM usuario_grupo WHERE cod_usuario = :cod_usuario AND cod_grupo not in (:groups);";
        $values = ['cod_usuario'=>$cod_usuario,'groups'=>$grupos];
        return $this->query($query,$values);

    }


    public function deleteUsersNotIn($cod_grupo,$except){
        $query = "DELETE FROM $this->table WHERE cod_grupo = :cod_grupo";
        $values = ['cod_grupo'=>$cod_grupo];
        if(count($except)){
            $users = implode(', ',$except);
            $query .= " AND cod_usuario not in (:users)";
            $values['users'] = $users;
        }
        $query.=";";
        return $this->query($query,$values);
        
    
    }
}