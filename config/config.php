<?php


  /**
   * Config:Paths
   */
  \Tolio\config::set('path:protocol', $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http', 'app');
  \Tolio\config::set('path:directory', '/tolio/', 'app');
  \Tolio\config::set('path:http', 'http://'.$_SERVER['SERVER_NAME'].'/', 'app');
  \Tolio\config::set('path:https', 'https://'.$_SERVER['SERVER_NAME'].'/', 'app');
  \Tolio\config::set('path:none', '//'.$_SERVER['SERVER_NAME'].'/', 'app');


  /*
   * Config:MySQL
   */
  \Tolio\config::set('db:name', 'tolio');
  \Tolio\config::set('db:host', 'localhost:3306');
  \Tolio\config::set('db:user', 'root');
  \Tolio\config::set('db:password', '5cbcd327');
  \Tolio\config::set('db:prefix', 'tolio_');

  /**
   *
   */
  \Tolio\config::set('page:theme:directory', 'standard');
  \Tolio\config::set('page:theme:name', 'Standard');