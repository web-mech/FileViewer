<?php
/**
  * Base class for controllers.
  *
  * These classes get invoked by the FrontController and the autoloader. This class isn't used directly.
  *
  * @author  Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  */
class Controller {
	public $view;
	protected $name;
	public function __construct(){
		$this->config = new Config();
		$reflector = new ReflectionClass($this);
		$this->name = substr($reflector->getName(),0,-10);
		$this->view = new View($this->config,$this->name);
	}

}