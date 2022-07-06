<?php

include'../app/application.php';
$controller = filter_get('p','menu');
$action = filter_get('a','index');

echo $controller;
echo $action;