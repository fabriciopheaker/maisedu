<?php

namespace core;
class Model {

  public function toArray(){
    return get_object_vars($this);
  }

  public function offArray(array $array){
    $class = SELF::CLASS;
    $obj= new $class();

    foreach($array as $key => $vale){
      $obj -> $key = $value
    }
  }
}