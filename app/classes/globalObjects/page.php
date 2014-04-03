<?php

  namespace Tolio;

  /**
   * Class page
   * @package Tolio
   */
  class page extends \Tolio\model{

    protected static $instance = null;


    public function __construct(){
    }

    /**
     * @return \Tolio\page
     */
    public static function get(){
      return parent::get();
    }

    public static function getPageIDByFileName($fileName){
      $fileName = (string)$fileName;

      $pageIDs = \Tolio\db::execQuery('SELECT pageID FROM '.\Tolio\config::get('db:prefix').'web_pages WHERE pageFilename = "'.$fileName.'"');

      return $pageIDs[0]['pageID'];
    }

    public static function getPageTemplateByPageID($pageID){
      $pageID = (int)$pageID;

      $pageTemplate = \Tolio\db::execQuery('SELECT pageTemplate FROM '.\Tolio\config::get('db:prefix').'web_pages WHERE pageID = "'.$pageID.'"');

      return $pageTemplate[0]['pageTemplate'];
    }

  }