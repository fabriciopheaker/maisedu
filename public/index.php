<?php
include '../app/application.php';


$request = \core\Request::getRequest();
$request->getAction()->run();
