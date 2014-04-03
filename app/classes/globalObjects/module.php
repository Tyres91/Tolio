<?php

  namespace Tolio;

  if (@secure !== TRUE) {
    die('forbidden');
  }

  /**
   * @author Rocky Ory
   * @since 1.0
   */
    class module extends \Tolio\model{

      /**
       * @param null $type
       *
       * @return \Tolio\module
       * @access public
       */
    public function __construct($type = null) {

    }

    public static function load($type, $namespace = null){
      $type = (string)$type;

      $modelAutoLoader = \Tolio\autoLoader::get();

      switch($type):
        case 'site':
          $modelHttp = \Tolio\http::get();
          $fileName = $modelHttp->getGet('file');
          $modelTheme = \Tolio\theme::get();
          $pageID = \Tolio\page::getPageIDByFileName($fileName);

          $pageThemeDirectory = \Tolio\config::get('page:theme:directory');

          $themeTemplate = $modelTheme->getTemplateByPageID($pageID);

          $headFiles = '';

          $headFiles .= $modelTheme->getThemeCssByThemeTemplate($themeTemplate);
          $headFiles .= $modelTheme->getThemeJavascriptByThemeTemplate($themeTemplate);

          $template = new \Tolio\template('theme/'.$pageThemeDirectory.'/templates', '/standard.tpl', false);


          $template->assignSmarty('headFiles', $headFiles);
          $templateString = $template->getTemplateHtml();
          $matches = null;
          $elements = array();
          preg_match_all('/.tolio:location id="[a-zA-Z]*".*/', $templateString, $matches);

          foreach($matches[0] as $element):
            $elements[] = $element;
          endforeach;

          $modelTheme->getElementsValueByElementsAndPageID($elements, $pageID);

          break;

        case 'plugin':
          $modelAutoLoader->load($namespace);
          static::run($namespace);
          break;
      endswitch;

    }


    public static function run($namespace){
      $namespace = (string)$namespace;
      $modelAutoLoader = \Tolio\autoLoader::get();

      $controller = $modelAutoLoader->getInstancedObject($namespace);

      //$className = static::getClassByNamespace($namespace);

      if(static::isCallable($controller)):
        $controller->initPlugin($namespace);
      endif;
    }

    public static function isCallable($controller) {
      $controller = (object)$controller;

      $isCallable = is_callable(array($controller, 'viewIndex'));

      return $isCallable;
    }

    public static function getClassByNamespace($namespace){
      $namespace = (string)$namespace;

      $namespaceAsArray = explode('/', $namespace);

      $class = end($namespaceAsArray);

      return $class;
    }
  }

?>