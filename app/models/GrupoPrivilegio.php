<?php

namespace models;
use \core\Model;

class GrupoPrivilegio extends Model{

    protected $pk = 'cod_grupo_privilegio';
    protected $table = 'grupo_privilegio';
    protected $connection = 'default';

    /**
     * Pega todos os grupos que tem permissão no modulo passado por parâmetro
     *
     * @param int $cod_modulo
     * @return array
     */
    public function getGruposModulo($cod_modulo){
        $query = 'cod_modulo =:cod_modulo';
        $value = ['cod_modulo'=>$cod_modulo];
        $result = $this->prepareQuery("cod_grupo",[$query,$value]);
        return $result->fetchAll(\PDO::FETCH_CLASS, Grupo::class);
    }

    /**
     * Pega todos os modulos que um grupo tem permissão
     *
     * @param int $cod_grupo
     * @return array
     */
    public function getModulosGrupo($cod_grupo){
        $query = 'cod_grupo =:cod_grupo';
        $value = ['cod_grupo'=>$cod_grupo];
        $result = $this->prepareQuery("cod_modulo",[$query,$value]);
        return $result->fetchAll(\PDO::FETCH_CLASS, Modulo::class);
    }
    
    
   /**
    * Deletar todos os grupos que não estão na lista  passada no array de grupos;
    *
    * @param int $cod_modulo
    * @param array $grupos
    * @return void
    */
    public function deleteGruposDoModulo($cod_modulo,array $grupos){
        $query = "DELETE FROM $this->table WHERE cod_modulo = :cod_modulo";
        $values = ['cod_modulo'=>$cod_modulo];
        if(count($grupos)){
            $grupos = implode(', ',$grupos);
            $query .= " AND cod_grupo not in (:groups)";
            $values['groups'] = $grupos;
        }
        $query.=";";
        return $this->query($query,$values);
    }

    /**
    * Deleta todos os modulos que não fram passados no array ;
    *
    * @param int $cod_grupo
    * @param array $modulos
    * @return void
    */
    public function deleteModulosDoGrupo($cod_grupo,array $except){
        $query = "DELETE FROM $this->table WHERE cod_grupo = :cod_grupo";
        $values = ['cod_grupo'=>$cod_grupo];
        if(count($except)){
           $modulos = implode(', ',$except);
           $query.=" AND cod_modulo not in (:modulos)";
           $values['modulos']=$modulos;
        }   
        $query.=";";
        return $this->query($query,$values);
    }
}