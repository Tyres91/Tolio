<?php

  namespace Tolio;

  /**
   * Class http
   * @package Tolio
   */
  class theme extends \Tolio\model{

    protected static $instance = null;

    /**
     *
     */
    public function __construct(){
    }

    /**
     * @return \Tolio\theme
     */
    public static function get(){
      return parent::get();
    }


    public function getThemeConfig(){
      $themeDirectory = \Tolio\config::get('page:theme:directory');
      $themeName = \Tolio\config::get('page:theme:name');
      $this->themePath = 'theme/'.$themeDirectory.SEPARATOR;
      include_once $this->themePath.'config.php';


      $themeConfigNamespace = '\Tolio\\'.$themeName;

      $themeConfig = $themeConfigNamespace::get();

      return $themeConfig;
    }

    public function getTemplateByPageID($pageID){

      $themeConfig = $this->getThemeConfig();

      $modelPage = \Tolio\page::get();

      $pageTemplate = $modelPage->getPageTemplateByPageID($pageID);

      return $themeConfig->$pageTemplate;
    }

    public function getThemeCssByThemeTemplate($themeTemplate){

      $themeCSS = '';

      foreach($themeTemplate['files']['css'] as $cssFile):
        $themeCSS .= $this->getThemeCss($cssFile);
      endforeach;

      return $themeCSS;
    }

    public function getThemeCss($file){

      if(is_file($file)):
        $cssTemplate = new \Tolio\template(null, 'app/templates/css.tpl');
        $cssTemplate->assignSmarty('file', $file);
        return $cssTemplate->getTemplateHtml();
      endif;

      return '';
    }

    public function getThemeJavascriptByThemeTemplate($themeTemplate){

      $themeJavascript = '';

      foreach($themeTemplate['files']['js'] as $javascriptFile):
        $themeJavascript .= $this->getThemeJavascript($javascriptFile);
      endforeach;

      return $themeJavascript;
    }

    public function getThemeJavascript($file){

      if(is_file($file)):
        $javascriptTemplate = new \Tolio\template(null, 'app/templates/javascript.tpl');
        $javascriptTemplate->assignSmarty('file', $file);

        return $javascriptTemplate->getTemplateHtml();
      endif;

      return '';
    }

    public function getElementsValueByElementsAndPageID($xmlElements, $pageID){
      $xmlElements = (array)$xmlElements;
      $pageID = (int)$pageID;

      $elements = array();

      $modelPageObject = \Tolio\pageObject::get();
      $modelPlugin = \Tolio\plugin::get();
      foreach($xmlElements as $xmlElement):
        $elementID = self::getLocationIDByElement($xmlElement);

        $pageObjectIDs = $modelPageObject->getPageObjectIDsByLocationIDAndPageID($elementID, $pageID);
        //$elements[$elementID]['pageObjectIDs'] = $pageObjectIDs;

        foreach($pageObjectIDs as $pageObjectID):
          $pageObject = $modelPageObject->getPageObjectByID($pageObjectID);
          $elements[$elementID]['pageObjects'][$pageObjectID] = $pageObject;
          $pluginData = $modelPlugin::getPluginDataByID($pageObject['pageID']);
          $elements[$elementID]['pageObjects'][$pageObjectID]['pluginData'] = $pluginData;
          $pluginNamespace = $modelPlugin::getPluginNameSpaceByPluginData($pluginData);
          $elements[$elementID]['pageObjects'][$pageObjectID]['pluginData']['namespace'] = $pluginNamespace;
          \Tolio\module::load('plugin', $pluginNamespace);
        endforeach;

      endforeach;
    }

    public function getElementValueByID($elementID){

    }

    /**
     * @param $element
     *
     * @return mixed
     */
    public static function getLocationIDByElement($element) {
      $idPart = str_replace('<tolio:location id="', '', $element);
      $idPart = str_replace('" />', '', $idPart);
      $locationID = trim($idPart);

      return $locationID;
    }
  }