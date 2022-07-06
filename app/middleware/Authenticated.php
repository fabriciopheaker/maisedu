<?php

namespace middleware;

use core\Session;
use core\Action;


class Authenticated{
    public function __construct($required = true){
        $user = Session::getSession()->user;
        if(is_null($user)&&$required){
            (new Action('login'))->redirect();
        }else if(!empty($user)&&!$required){
            (new Action())->redirect();
        }
    }
}
