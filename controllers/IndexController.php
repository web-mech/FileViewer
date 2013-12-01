<?php 
/**
  * Default Controller. 
  *
  * This is the default controller set in the config file. 
  * This is loaded by the FrontController.
  * This is run when you first run the app. or if you go to /index/show, or just /index.
  * 
  * @author Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  */
class IndexController extends Controller {
	protected $models = array();

	public function __construct(){
		parent::__construct();
		$this->models['index']	= new IndexModel();
	}	

	public function show(){
		$this->view->setTemplate('show')->render();
	}
}
