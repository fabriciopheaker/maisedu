<?php

namespace components;

use core\Action;
use core\Request;
use core\Session;
use models\Modulo;

class Menu extends \core\Components{

    private $submenu;
    public  $modulo; 
    private $visivel;
    private $href;
    private $tipo;
    private $active = false;
    private $open = false;

   public function __construct($modulos = null, Modulo $modulo = null, Menu $pai = null){
       $session = Session::getSession();
       $request = Request::getRequest();
       $this->href  = "#";
       $this->tipo  = 'box';
       $this->visivel = false;
       $this->pai = $pai;
       $this->modulo = $modulo;
       if(isset($modulo)){
            if(isset($modulo->controller)){
                // @var models\Usuario $session->user
                $this->setVisivel($session->user->checkPrivilegio($modulo->cod_modulo));
                $this->tipo = 'controller';
                $this->href = Action::get($modulo->controller,$modulo->action)->getUrl();
                if($modulo->controller == $request->getController() && $request->getMethod() == $modulo->action){
                    $this->setActive(true);
               }
            }else if($modulo->url){
                $this->tipo = 'url';
                $this->href = $modulo->url;
                $this->setVisivel(true);
            }
        }
        parent::__construct('menu.php');
        $this->submenu=[];
        if(is_null($modulos)){
            $modelmodulo = new Modulo();
            $modulos = $modelmodulo->findAll("*",null,null,'cod_modulo_pai asc, ordem asc, cod_modulo desc;');
        }
        $this->constructSubmenu($modulos);
        
   }


   private function setVisivel(bool $value){
       $this->visivel = $value;
       if($value && $this->pai){
            $this->pai->setVisivel($value);
       }
   }

   private function setActive(bool $value){
        $this->active = $value;
        if($value && $this->pai){
            $this->pai->setActive($value);
            $this->pai->open = $value;
        }
    }



   public function constructSubmenu($modulos){
      
       $cod_pai = (is_null($this->modulo))?null:$this->modulo->cod_modulo;
       //var_dump($this->pai->modulo);
       $submenu = [];
       foreach($modulos as $key => $item){
           if($cod_pai == $item->cod_modulo_pai){
               $submenu[] = $item;
               unset($modulos[$key]);
           }
       }
       foreach($submenu as $menu){
           $newmenu= new Menu($modulos,$menu,$this);
           $this->submenu[] = $newmenu;
       }
   }


   private function renderMenu(){
       foreach($this->submenu as $menu){
           if($menu->visivel){
                $open = ($menu->open)?" menu-open":"";
                $active = ($menu->active)?" active":"";
                echo "<li class='nav-item$open'>";
                echo "<a href='$menu->href' class='nav-link$active'>";
                echo "<i class='nav-icon ". $menu->modulo->icone."'></i><p>";
                echo $menu->modulo->menu;
                if(count($menu->submenu)){
                    echo '<i class="fas fa-angle-left right"></i></p></a>';
                    echo '<ul class="nav nav-treeview">';
                    $menu->renderMenu();
                    echo '</ul>';
                }else{
                    echo '</p></a>';
                }
                echo '</li>';
           }
       }
   }

   public function show(){
       $this->session = Session::getSession();
       $pessoa = $this->session->user->getPessoa();
       $this->usuario_nome = (isset($pessoa->apelido))?$pessoa->apelido:$pessoa->nome;
       $render = function () {
           $this->renderMenu();
       };
       extract($this->__variaveis);
       require $this->view;
   }


   public function printMenu($nivel=">>"){
        foreach($this->submenu as $menu){
            $visivel  = ($menu->visivel) ? "visivel" : "Invisivel";
            echo $nivel.$menu->modulo->menu."($visivel)<br/>";
            if(count($menu->submenu)){
                $menu->printMenu($nivel.">>");
            }
        }
        

   }
}


      