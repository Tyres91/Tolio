<?php

  namespace Tolio;

  /**
   * Class http
   * @package Tolio
   */
  class http extends \Tolio\model{

    /**
     * @var array
     */
    private $get = array();
    /**
     * @var array
     */
    private $post = array();
    /**
     * @var array
     */
    private $session = array();

    /**
     *
     */
    public function __construct(){
      $this->setGet();
      $this->setPost();
      $this->setSession();
    }

    /**
     * @return \Tolio\http
     */
    public static function get(){
      return parent::get();
    }

    /**
     * @param $getKey
     *
     * @return mixed
     */
    public function getGet($getKey){
      return $this->get[$getKey];
    }

    /**
     * @param null $getKey
     * @param null $getValue
     */
    public function setGet($getKey = null, $getValue = null){
      if($getKey === null):
        $this->get = $_GET;
        return;
      endif;

      $this->get[$getKey] = $getValue;
    }

    /**
     * @param $postKey
     *
     * @return mixed
     */
    public function getPost($postKey){
      return $this->post[$postKey];
    }

    /**
     * @param null $postKey
     * @param null $postValue
     */
    public function setPost($postKey = null,$postValue = null){
      if($postKey != null)
        $this->post = $_POST;

      $this->post[$postKey] = $postValue;
    }

    /**
     * @param $sessionKey
     *
     * @return mixed
     */
    public function getSession($sessionKey){
      return $this->session[$sessionKey];
    }

    /**
     * @param null $sessionKey
     * @param null $sessionValue
     */
    public function setSession($sessionKey = null,$sessionValue = null){
      if($sessionKey != null)
        $this->session = $_SESSION;

      $this->session[$sessionKey] = $sessionValue;
    }

    /**
     * @param string $ContentType
     * @param string $charset
     *
     * @return void
     * @access public
     * @static
     */
    public static function contentType($ContentType = 'text/html', $charset = 'UTF-8') {
      self::send('Content-type:'.$ContentType.'; charset='.$charset);
    }

    /**
     * @param $header
     *
     * @return void
     * @access public
     * @static
     */
    public static function send($header) {
      if(self::isSent($header) == false)
        header($header);
    }

    /**
     * @param $header
     *
     * @return boolean
     * @access public
     * @static
     */
    public static function isSent($header) {
      return in_array($header, headers_list()) ? true : false;
    }

    /**
     * @param $key
     *
     * @return array
     * @access public
     */
    public function getFile($key) {
      if($this->issetFile($key))
        return $this->file[$key];
      return null;
    }

    /**
     * @param $key
     *
     * @return boolean
     * @access public
     */
    public function issetFile($key) {
      return (isset($this->file[$key]));
    }

    /**
     * @param $key
     *
     * @return string
     * @access public
     */
    public function getFileContent($key) {
      $file = $this->getFile($key);
      if(
        !empty($file['tmp_name'])
        && file_exists($file['tmp_name'])
        && is_readable($file['tmp_name'])
      ):
        $content = file_get_contents($file['tmp_name']);
        return $content;
      endif;
    }
  }