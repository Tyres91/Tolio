<?php

  namespace Tolio;

  /**
   * Class pageObjects
   * @package Tolio
   */
  class pageObject extends \Tolio\model{

    protected static $instance = null;


    public function __construct(){
    }

    /**
     * @return \Tolio\pageObject
     */
    public static function get(){
      return parent::get();
    }

    public static function getPageObjectByID($pageObjectID){
      $pageObjectID = (int)$pageObjectID;

      $pageObject = \Tolio\db::execQuery('SELECT * FROM '.\Tolio\config::get('db:prefix').'web_pages_objects WHERE pageObjectID = '.$pageObjectID);

      return @$pageObject[0];
    }

    public static function getPageObjectIDsByLocationIDAndPageID($locationID, $pageID){
      $pageID = (int)$pageID;
      $locationID = (string)$locationID;

      $pageObjectIDs = array();

      $pageObjectIDsQueryResult = \Tolio\db::execQuery(
          'SELECT pageObjectID, sortID'.
          ' FROM '.\Tolio\config::get('db:prefix').'web_pages_objects'.
          ' WHERE locationID = "'.$locationID.'"'.
            ' AND pageID='.$pageID.
          ' ORDER BY sortID ASC'
      );

      foreach((array)$pageObjectIDsQueryResult as $pageObjectIDQueryResult):
        $pageObjectIDs[] = $pageObjectIDQueryResult['pageObjectID'];
      endforeach;

      return $pageObjectIDs;
    }

  }