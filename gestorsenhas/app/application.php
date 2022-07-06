<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH',realpath(__DIR__.'/..'));
defined('APP_PATH')         || define('APP_PATH',APPLICATION_PATH.'/app');
defined('TEMPLATES_PATH')   || define('TEMPLATES_PATH',APP_PATH.'/templates');
defined('VIEWS_PATH')       || define('VIEWS_PATH',APP_PATH.'/views');
defined('URL')              || define('URL','http://'.$_SERVER['HTTP_HOST'].'/gestorsenhas');


spl_autoload_register(function($class){

   //include'../app/core/View.php';
  $class = str_replace('\\','/',$class);
  include APP_PATH."/$class.php";
  die();

});


function filter_get($var,$default=null){
  $temp = filter_input(INPUT_GET, $var, filter_sanitize_string);
  if( isset($default)&& empty($temp)){
    return $default;
  }
  return $temp;
}