<?php

if(@secure !== true)
  die('forbidden');

/**
 * @param $data
 */
function pre($data) {
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
}

/**
 * @param $data
 */
function l($data) {
  file_put_contents(APP_ROOT.'log.txt', $data);
}

?>