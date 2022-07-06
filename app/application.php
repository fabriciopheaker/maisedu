<?php

date_default_timezone_set('America/sao_paulo');

defined('APPLICATION_PATH')    || define('APPLICATION_PATH', realpath(__DIR__ . '/..'));
defined('APP_PATH')            || define('APP_PATH', APPLICATION_PATH . '/app');
defined('TEMPLATES_PATH')      || define('TEMPLATES_PATH', APP_PATH . '/templates');
defined('CONFIGS_PATH')        || define('CONFIGS_PATH', APP_PATH . '/configs');
defined('VIEWS_PATH')          || define('VIEWS_PATH', APP_PATH . '/views');
defined('URL')                 || define('URL', 'http://' . $_SERVER['HTTP_HOST'] . '/maisedu/public');
defined('DEFAULT_TEMPLATE')    || define('DEFAULT_TEMPLATE', 'main.php');
defined('APPLICATION_TITLE')   || define('APPLICATION_TITLE', 'Mais Edu');
defined('APPLICATION_VERSION') || define('APPLICATION_VERSION', '1.0.0');
defined('HOMEPAGE')            || define('HOMEPAGE', 'Home');
defined('CACHE_PATH')          || define('CACHE_PATH', APPLICATION_PATH . '/cache');
defined('PAGE_404')            || define('PAGE_404', 'Notfound');
defined('SESSION_NAME')        || define('SESSION_NAME', 'MAISEDU');
defined('APPLICATION_ENV')     || define('APPLICATION_ENV', 'development');
defined('REQUEST_DELAY')       || define('REQUEST_DELAY', 2);
defined('REQUEST_TIMEOUT')     || define('REQUEST_TIMEOUT', 40);
defined('SELF_REGISTER')       || define('SELF_REGISTER', true);
defined('COLOR_DEFAULT')       || define('COLOR_DEFAULT', 'navy');


spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    if (!file_exists(APP_PATH . "/$class.php") && APPLICATION_ENV == 'production') {
        throw new Exception("Classe não existe");
    }
    include APP_PATH . "/$class.php";
});

defined('MODEL_AUTHENTICATE')  || define('MODEL_AUTHENTICATE', \models\Usuario::class);
