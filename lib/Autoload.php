<?php
/**
  * Autoloader class used for dynamically loading our controllers and having a path driven control flow.
  *
  * To avoid a nested mess of includes, we've provided an autoloader, which will attempt to load a class from either the lib/ models/ or controlers/ directory.
  *
  * @author  Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  *
  * @param Config $config Configuration settings.
  *
  * @todo Make the directories to be loaded configurable.
  */
class AutoLoader {
	protected  $config;
	/**
	 * The AutoLoader contructor loads searches default directories for classes to load.
	 */
	public function __construct($config){
		$this->config = $config;
		spl_autoload_register(array('AutoLoader','libs'));
		spl_autoload_register(array('AutoLoader', 'models'));
		spl_autoload_register(array('AutoLoader', 'controllers'));
	}
	
	private function libs($cls){
		$this->load($cls,'lib/');
	}

	private function models($cls){
		$this->load($cls,'models/');
	}

	private function controllers($cls){
		$this->load($cls,'controllers/');
	}

	private function load($cls, $path){
		if(class_exists($cls)) {
            return false;
        }
        
        $clsPath = $this->config->baseDir . "/" . $path .$cls . '.php';
        
        if((file_exists($clsPath) === false) || (is_readable($clsPath) === false)) {
            return false;
        }

        require($clsPath);
	}
}