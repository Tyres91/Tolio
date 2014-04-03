<?php

  namespace Tolio;

  /**
   * Class config
   * @package Tolio
   */
  class config {

    /**
     * @var array
     */
    private static $configs = array();

    /**
     * @param $name
     * @param $value
     * @param int $namespace
     */
    public static function set($name, $value, $namespace = 0){
      $name = (string)$name;
      $value = (string)$value;

      self::$configs[$name] = array(
        'value' => $value,
        'namespace' => $namespace
      );
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function get($name){
      $name = (string)$name;

      $configParameter = self::$configs[$name]['value'];

      return $configParameter;
    }

    /**
     * Returns all variables in a namespace
     * @param string $namespace
     * @return mixed
     * @access public
     * @static
     */
    public static function getVars($namespace = 'app') {
      $return = array();
      foreach(self::$configs as $varKey => $Variable)
        if($Variable['namespace'] == $namespace)
          $return[$varKey] = $Variable['value'];
      return $return;
    }

  }