<?php

  namespace Tolio;

  /**
   * Class template
   * @package Tolio
   */
  class template {

    /**
     * @var \Smarty()
     */
    private $smartyObject;

    private $html = '';
    private $template = '';

    public function __construct($templateDirectory = null, $template = null, $debug = false){
      $this->setSmarty($templateDirectory, $debug);

      $templateFilePath = $this->buildTemplateFilePath($templateDirectory, $template);

      $this->template = $templateFilePath;

      if($handle = @fopen($templateFilePath, 'r')):
        $fileSize = filesize($templateFilePath);
        $this->html = $fileSize == 0 ? '' : fread($handle, $fileSize);
      endif;
    }

    public function display() {
      $html = $this->get();
      $this->smartyObject->display('string:'.$html);
    }

    public function getTemplateHtml(){
      $templateHtml = $this->smartyObject->fetch($this->template);

      return $templateHtml;
    }

    /**
     * @return string
     * @access public
     */
    public function get() {

      //$this->parseConfig();
      //$this->parseTranslations();
      //$this->parsePHP();
      //$this->parseDB();

      //$this->html = $this->smartyObject->display($template);


      return $this->html;

    }

    /**
     * @return void
     * @access private
     */
    private function parseConfig() {
      $Vars = \Tolio\config::getVars('app');
      foreach($Vars as $Var_Name => $Var_Value)
        if(!is_array($Var_Value))
          $this->assign('app:'.$Var_Name, $Var_Value);
    }

    /**
     * @param $search
     * @param string $replace
     *
     * @return object
     * @access public
     */
    public function assignSmarty($search, $replace = '') {
      $search = (string)$search;
      $replace = (string)$replace;

      $this->smartyObject->assign($search, $replace);
    }

    /**
     * @param $templateDirectory
     * @param $debug
     */
    private function setSmarty($templateDirectory, $debug) {
      $smarty = new \Smarty();
      $this->smartyObject = $smarty;
      $this->smartyObject->debugging = $debug;

      $this->smartyObject->setCompileDir(strtolower(APP_ROOT . 'app/smarty/templates_c/'));
      $this->smartyObject->setConfigDir(strtolower(APP_ROOT . 'app/smarty/configs/'));
      $this->smartyObject->setCacheDir(strtolower(APP_ROOT . 'app/smarty/cache/'));
      if($templateDirectory === null)
        $this->smartyObject->setTemplateDir(strtolower(APP_ROOT . 'app/smarty/templates'));
      else
        $this->smartyObject->addTemplateDir(strtolower(APP_ROOT . $templateDirectory));
    }

    /**
     * @param $templateDirectory
     * @param $template
     *
     * @return string
     */
    private function buildTemplateFilePath($templateDirectory, $template) {
      $templateFile = strtolower(APP_ROOT . $templateDirectory).$template;

      return $templateFile;
    }
  }