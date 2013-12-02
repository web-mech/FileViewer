<?php
/**
  * A simple config class.
  *
  * This class is used to store settings about the app. You want to configure this to your environment.
  *
  * @author Michael Price <webmech@gmail.com>
  * 
  * @since 1.0
  */
class Config {
	public $db = 'pageViewer'; //database name
	public $host = 'localhost'; //server location
	public $user = 'root'; //user
	public $pass = ''; //password
	public $baseDir = ''; //absolute path to your app.
	public $basePath = ''; //relative path to your app for everything else within.
	public $viewDir = 'views/'; //where your views are stored.
	public $defaultLayout = 'main'; //default layout loaded.
	public $defaultController = 'Index'; //default controller ran.
	public $defaultAction = 'show'; //default action taken, your controller must have this method defined.
	public $pageDir = 'page/'; //where page content is stored.

	public function __construct(){
		$this->baseDir = dirname(__FILE__);
		if($this->baseDir == $_SERVER['DOCUMENT_ROOT']){
			$this->basePath = "";
		}else{
			$this->basePath = substr($this->baseDir,strrpos($this->baseDir,"/"));	
		}
			
		
	}
}