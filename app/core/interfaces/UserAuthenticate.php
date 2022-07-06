<?php 

namespace core\interfaces;

interface UserAuthenticate{
    public function authenticate($login,$senha);
    public function logout();
}