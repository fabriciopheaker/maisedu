<?php

namespace core;
class View {
  protected $view;
  protected $template;
  protected $__variaveis;

  public function __construct($template,$view){
    $this->template = $template;
    $this->view = VIEWS_PATH."/$view";
  }

    public function show(){
      require TEMPLATES_PATH."/$this->template";
    }

  }
