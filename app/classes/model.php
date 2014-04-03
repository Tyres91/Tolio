<?php

  namespace Tolio;

  if(@secure !== true)
    die('forbidden');

  /**
   * @author Rocky Ory
   * @since 1.0
   */
  class model {

    protected static $instance = null;

    public function __construct(){
      if(static::$instance === null)
        static::$instance = new static();
      return static::$instance;
    }

    /**
     * @return \Tolio\model
     * @access public
     * @static
     */
    public static function get() {
      if(static::$instance === null)
        static::$instance = new static();
      return static::$instance;
    }

  }

?>
