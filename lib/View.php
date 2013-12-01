<?php
/**
  * This class is responsible for loading views.
  * 
  * There are three types of Views. 
  * * Layouts - Define the overall layout of the view.
  * * Main View - This is the main view that corresponds to which ever controller you are viewing. e.g. IndexView.php
  * * Templates - This is view corresponds to what action is executed on the main controller. This is the sub-view.
  *
  * @author Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  */
class View {
	protected $path;
	protected $layout;
	protected $template;
	protected $dir;
	protected $ext = 'php';
	
	public function __construct($config,$name){
		if(!$config || !$name)
			return;
		$this->config = $config;
		$this->dir = $this->config->viewDir;
		$this->name = $name;
		$this->setPath($this->name); //set the default view;
		$this->setLayout($this->config->defaultLayout); //set the overall layout;
		$this->setTemplate($this->config->defaultAction); //set the default template;
		return $this;
	}

	public function setPath( $name ){
		$this->path = $this->resolve(sprintf("%s%s.%s",$this->dir,$name."View",$this->ext));
		return $this;
	}

	public function setLayout( $name ){
		$this->layout = $this->resolve(sprintf("%s%s/%s.%s",$this->dir,'layouts',$name,$this->ext));
		return $this;
	}

	public function setTemplate( $name ){
		$this->template = $this->resolve(sprintf("%s%s/%s/%s.%s",$this->dir,'templates',$this->name, $name,$this->ext));
		return $this;
	}
	
	public function render($data=stdClass){
		$this->data = $data;
		include_once $this->layout;
	}

	/**
	 * Display error message
	 */
	public function error($message){
		$html = '<div class="error">%s</div>';
		die(sprintf($html,$message));
	}

	/**
	 * Determine if we have a valid view
	 */
	private function resolve($path){
		if((file_exists($path) === false) || (is_readable($path) === false)) {
            $this->error("Could not find view: \"{$path}\".");
        }
        return $path;
	}


}