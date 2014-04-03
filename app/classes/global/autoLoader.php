<?php

  namespace Tolio;

  if(@secure !== true)
    die('forbidden');


  /**
   * Class autoLoader
   * @package Tolio
   */
  class autoLoader {

    private static $objects;

    private static $instance = null;

    /**
     * @return \Tolio\autoLoader
     * @access public
     * @static
     */
    public static function get() {
      if(static::$instance === null)
        static::$instance = new static();
      return static::$instance;
    }

    public function __construct() {
      spl_autoload_register(array(__NAMESPACE__ .'\autoLoader', 'load'));
      \Tolio\autoLoader::loadGlobals();
      \Tolio\autoLoader::loadGlobalObjects();
    }

    /**
     * @param string $namespace
     *
     * @return void
     * @access public
     * @static
     */
    public function load($namespace = '') {
      $namespace = (string)$namespace;

      $cleanNamespace = $namespace;

      if(substr($namespace, 6, 7) == 'plugins'):
        $cleanNamespace = 'plugin';
      endif;

      switch($cleanNamespace):
        case 'plugin':
          $filename = substr($namespace,6).'.php';
          if(is_file(APP_ROOT.$filename)):
            include_once APP_ROOT.$filename;
          endif;
          break;
      endswitch;
    }


    private static function loadGlobals(){
      if ($handle = opendir('app/classes/global')):
        while (false !== ($file = readdir($handle))):
          $filePath = APP_ROOT.'app/classes/global/'.$file;
          if(is_file($filePath)):
            include_once $filePath;
          endif;
        endwhile;

        closedir($handle);
      endif;
    }

    private static function loadGlobalObjects(){

      include_once APP_ROOT.'app/classes/model.php';

      if ($handle = opendir('app/classes/globalObjects')):
        self::includeGlobalObjects($handle);
      endif;
      closedir($handle);

    }

    /**
     * @param $handle
     *
     * @return array
     */
    private static function includeGlobalObjects($handle) {
      while (false !== ($file = readdir($handle))):
        $filePath = APP_ROOT . 'app/classes/globalObjects/' . $file;
        if(is_file($filePath)):
          include_once $filePath;
        endif;
      endwhile;
    }

    /**
     * @param $handle
     */
    private static function instanceGlobalObjects($handle) {


      while (false !== ($file = readdir($handle))):
        $filePath = APP_ROOT . 'app/classes/globalObjects/' . $file;
        if(is_file($filePath)):
          $className = substr($file, 0, -4);
          $classNameSpace = '\Tolio\\' . $className;
          if(empty(self::$objects[$className]))
            self::$objects[$className] = new $classNameSpace();
        endif;
      endwhile;
    }

    /**
     * @param null $autoLoader
     *
     * @return void
     * @access public
     * @static
     */
    public function register($autoLoader = null) {

      if($autoLoader === null):
        spl_autoload_register('\Tolio\autoLoader');
      else:
        spl_autoload_register($autoLoader);
      endif;

    }

    public function index(){
      $this->register();
    }

    public function getInstancedObject($namespace, $view = 'Index'){
      $namespace = (string)$namespace;


      $controller = new $namespace($view);

      return $controller;
    }
  }


  include_once APP_ROOT.'app/config/config.php';
  include_once APP_ROOT.'app/classes/global/debug.php';
  new autoLoader();