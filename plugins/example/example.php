<?php

  namespace Tolio\plugins\example;

  class example extends \Tolio\plugin{


    public function viewIndex(){
      new \Tolio\template('plugins/example/templates/');
    }
  }