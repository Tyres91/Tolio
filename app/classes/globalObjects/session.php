<?php

  namespace Tolio;

  if(@secure !== true)
    die('forbidden');

  /**
   * @author Dirk Gnauck
   * @since 3.0
   * @static
   */
  class session {

    public static function start() {

      session_set_save_handler(
        array('\Tolio\session', 'open'),
        array('\Tolio\session', 'close'),
        array('\Tolio\session', 'read'),
        array('\Tolio\session', 'write'),
        array('\Tolio\session', 'destroy'),
        array('\Tolio\session', 'gc')
      );

      session_start();
      if(session_id() == '')
        session_regenerate_id();
    }

    /**
     * @return void
     * @access public
     * @static
     */
    public static function open() {
      \Tolio\db::connect();
    }

    public static function close() {

    }


    public static function read() {

    }

    /**
     * @return void
     * @access public
     * @static
     */
    public static function write() {

    }

    /**
     * @return void
     * @access public
     * @static
     */
    public static function destroy() {
    }

    /**
     * @return void
     * @access public
     * @static
     */
    public static function gc() {

    }
  }