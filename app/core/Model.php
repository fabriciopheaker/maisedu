<?php

namespace core;


use Exception;

class Model{
    
    private $__data = [];
    protected $pk;
    private $codigo;
    protected $table;
    protected $connection = 'default';
/**
 * Undocumented function
 *
 * @param [type] $codigo
 * @param array|null $where [(string)$query,array('value1'=>"value"];
 */
    public function __construct($codigo = null, $where = null){
        $this->codigo = $codigo;
        if(is_null($codigo) && count($this->__data)){
            $this->codigo = $this->__data[$this->pk];
            unset($this->__data[$this->pk]);
        }

        if(is_null($this->codigo) && isset($where)){
            $data = $this->prepareQuery("*",$where)->fetch(\PDO::FETCH_ASSOC);
            if($data){
                $this->codigo = $data[$this->pk];
                $this->setData($data);
            }
           
        }
           
    }
/**
 * sobrescreve o compostamento padrão de set da class
 * ou seja no lugar de criar um atributo novo ao chamar o objeto ela chama o método
 * ex: $this->x = 5 vira $this->__set('x',5);
 *
 * @param [string] $key
 * @param [type] $value
 */
    public function __set($key, $value){
        $this->__data[$key] = $value;
    }

    public function __get($key){
        if($key==$this->pk){
            return $this->codigo;
        }
        if(!count($this->__data)){
           $this->load() ;    
        }
        if(array_key_exists($key, $this->__data)){
            return $this->__data[$key];
        }

        
        return null;
    }
    public function __isset($name){
        $name = $this->__get($name);
        return isset($name);
    }
    private function load(){
        if(intval($this->codigo)>0){
            $sql = "SELECT * FROM $this->table WHERE $this->pk = :$this->pk;";
            $stm = $this->query($sql,[$this->pk=>$this->codigo]);
            $this->setData($stm->fetch(\PDO::FETCH_ASSOC));
        }   
    }

    public function save($data = null){
        if(is_null($data)){
            $data = $this->__data;
            $this->__data = []; 
        }
        if(array_key_exists($this->pk, $data)){
            unset($data[$this->pk]);
        }
        if(intval($this->codigo)>0){
           return  $this->update($data);
        }
        return $this->insert($data);
    }
    private function insert($data){
        //['nome'=>'Joaquim Scavone'];
        $sql = "INSERT INTO $this->table (";
        $values = " VALUES (";
        $virgula = '';
        foreach($data as $column => $value){
            $sql.=$virgula.$column;
            $values.="$virgula:$column";
            $virgula = ',';
        }
        $sql.=") $values);";
        $this->query($sql,$data);
        $this->codigo = $this->getLastInsertId();
    }

    protected function query($sql,array $data = null){
        $conn = Connection::getConnection($this->connection);
        $stm = $conn->prepare($sql);
        $stm->execute($data);
        return $stm;
    }

    private function getLastInsertId(){
        $conn = Connection::getConnection($this->connection);
        return $conn->lastInsertId($this->table);
    }

    private function update($data){
            //['cpf'=>'1121111'];
            //UPDATE `pessoa` SET `cpf` = '1111', rg = '4fsdafas' WHERE (`cod_pessoa` = '1');
            $virgula = '';
            $sql = "UPDATE $this->table SET";
            foreach($data as $column => $value){
                $sql.="$virgula $column = :$column";
                $virgula = ',';
            }
            $sql.= " WHERE $this->pk = :$this->pk";
            $alldata = array_merge($data, [$this->pk => $this->codigo]);
            $this->query($sql,$alldata);
    }

    public function delete(){
        if(intval($this->codigo)>0){
            $sql = "DELETE FROM $this->table WHERE $this->pk = :$this->pk;";
            $this->query($sql,[$this->pk=>$this->codigo]);
            $this->__data = []; 
            $this->codigo = null;
        }   
    }

    public function setData(array $data){
        if(array_key_exists($this->pk,$data)){
            unset($data[$this->pk]);
        }
        
        $this->__data = $data;
    }


    public function getData(){
        if(!count($this->__data)){
            $this->load() ;    
        }
        return array_merge([$this->pk => $this->codigo],$this->__data);
    }


    /**
     * Busca vários registros na base de dados
     *
     * @param string|array $columns
     * @param array $where [condição,[$valores]] ['nome like %:nome% AND cpf = :cpf',
     *                     ['nome'=>'fulano',cpf=>'11111111111']
     *                      ])
     * @param int | array $limit numero de regitros [inicio_registros,fim_registros];
     * @return array[Model]
     */
    public function findAll($columns = "*", array $where = null, $limit = null, string $order_by = null){
        $result = $this->prepareQuery($columns, $where, $limit, $order_by);
        return $result->fetchAll(\PDO::FETCH_CLASS, get_class($this));
    }
    /**
     * Busca um registro n obanco de dados
     *
     * @param string|array $columns
     * @param array $where [condição,[$valores]] ['nome like %:nome% AND cpf = :cpf',
     *                     ['nome'=>'fulano',cpf=>'11111111111']
     *                      ])
     * @param string $order_by nome asc, cpf desc
     * @return get_class($this)
     */
    public function find($columns = "*", array $where = null, string $order_by = null){
        $result = $this->prepareQuery($columns, $where, null, $order_by);
        return $result->fetchObject(get_class($this));
        
    }


    protected function prepareQuery($columns = "*", array $where = null, $limit = null, string $order_by = null){
        $values = null;
        if(is_array($columns)){
           $columns = implode(', ', $columns);
        }
        $sql = "SELECT $columns FROM $this->table";
        if(!empty($where)){
            if(is_array($where) && count($where)==2){
                $values = $where[1];
                $sql.=" WHERE ".$where[0];
            }else{
                throw new \Exception("Parâmetro where com formato inválido");
            }
        }
        if(!empty($order_by)){
            $sql.=" ORDER BY $order_by";
        }
        if(!empty($limit)){
            if(is_array($limit)){
                $limit = implode(', ', $limit);
            }
            $sql.=" LIMIT $limit";
        }
        $sql.=";";
        return $this->query($sql,$values);
    }

    /**
     * Retorna a quantidade de registros para um consulta específica.
     * @param array $where [condição,[$valores]] ['nome like %:nome% AND cpf = :cpf',
     *                     ['nome'=>'fulano',cpf=>'11111111111']
     *                      ])
     * @return int
     */
    public function count($where = null){
        $result = $this->prepareQuery("count($this->pk) as quantidade", $where, null, null);
        return (int) $result->fetchColumn();
    }

    public function showColumns(){
        $sql = "SHOW COLUMNS FROM ".$this->table;
        return $this->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}