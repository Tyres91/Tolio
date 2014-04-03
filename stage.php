<?php
  error_reporting(E_ALL);

  define('secure', true);
  define('SEPARATOR', '/');
  define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
  define('DIRNAME', dirname(__FILE__).'/');

  include_once DIRNAME.'app/classes/global/config.php';
  include_once DIRNAME.'config/config.php';

  $pathDirectory = \Tolio\config::get('path:directory');

  define('APP_ROOT', DOCUMENT_ROOT.$pathDirectory);


  include_once APP_ROOT.'app/classes/global/autoLoader.php';

  \Tolio\session::start();
  \Tolio\module::load('site');
