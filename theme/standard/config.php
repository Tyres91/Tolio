<?php
  namespace Tolio;

  class Standard extends \Tolio\theme{

    protected static $instance = null;

    public $standard = array(
      'tpl' => 'standard.tpl',
      'files' => array(
        'css' => array(
          'app/css/normalize.css',
          'theme/standard/css/standard.css'
        ),
        'js' => array(
          'theme/standard/js/standard.js'
        )
      )
    );

    /**
     * @return \Tolio\Standard
     */
    public static function get(){
      return parent::get();
    }
  }