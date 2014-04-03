<?php

  namespace Tolio;

  class db extends \PDO{

    /**
     * @var \PDO
     */
    public static $db;

    private static
      $dbHost,
      $dbName,
      $dbUser,
      $dbPassword,
      $dbPrefix;


    public function __construct(){
    }

    public static function connect(){
      self::setProperties();

      static::$db = new \PDO('mysql:host='.static::$dbHost.';dbname='.static::$dbName, static::$dbUser, static::$dbPassword, array(
        \PDO::ATTR_PERSISTENT => true
      ));
    }

    private static function setProperties() {
      static::$dbHost = \Tolio\config::get('db:host');
      static::$dbName = \Tolio\config::get('db:name');
      static::$dbUser = \Tolio\config::get('db:user');
      static::$dbPassword = \Tolio\config::get('db:password');
      static::$dbPrefix = \Tolio\config::get('db:prefix');
    }

    public static function execSearch(){

    }

    public static function execQuery($query){
      $query = (string)$query;

      $queryObject = static::$db->prepare($query);

      $queryObject->execute();

      $pdoResult = $queryObject->fetchAll(\PDO::FETCH_ASSOC);

      return $pdoResult;
    }

    public static function execClose(){
      static::$db = null;
    }

    public static function getLastInsertID(){
      $lastInsertID = \PDO::lastInsertId();

      return $lastInsertID;
    }

  }