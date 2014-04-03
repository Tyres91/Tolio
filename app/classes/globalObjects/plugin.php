<?php

  namespace Tolio;

  /**
   * Class page
   * @package Tolio
   */
  class plugin extends \Tolio\model{

    protected static $instance = null;

    public $view = null;

    public function __construct(){
    }

    /**
     * @return \Tolio\plugin
     */
    public static function get(){
      return parent::get();
    }

    public static function getPluginDataByID($pluginID){
      $pluginID = (int)$pluginID;

      $pluginData = \Tolio\db::execQuery('SELECT * FROM '.\Tolio\config::get('db:prefix').'web_plugins WHERE pluginID = '.$pluginID);

      return $pluginData[0];
    }

    public static function getPluginNameSpaceByPluginData($pluginData){
      $pluginData = (array)$pluginData;

      $pluginPath = str_replace('/','\\', $pluginData['pluginPath']);

      $pluginNameSpace = '\Tolio\plugins\\'.$pluginPath.'\\'.$pluginData['pluginClass'];

      return $pluginNameSpace;
    }

    public function initPlugin($namespace){
      $namespace = (string)$namespace;

      pre($namespace);
      $pluginDirectory = explode('\\', $namespace);

      $this->view = new template('plugins/'.$pluginDirectory.'templates/Index.tpl');

    }
  }