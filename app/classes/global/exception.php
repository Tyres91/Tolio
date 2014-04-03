<?php

namespace Tolio;

if(@secure !== true)
  die('forbidden');

/**
 * @author Dirk Gnauck
 * @since 3.0
 */
class exception extends \Exception {

  /**
   * @param string $msg
   * @param int $idType
   * @param \Exception $id
   *
   * @return \Tolio\exception
  @access public
   */
  public function __construct($msg, $idType, $id) {

    echo $msg;

    if(!empty($idType))
      echo ' ['.$idType.': '.$id.']';

    exit;

  }
}