<?php
/**
  * Rest Controller for interacting with the client code.
  * 
  * This controller sends a list of possible documents and retreives documents based on name or id.
  * 
  * @author Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  */
class PageController extends Rest {
	
	public function __construct(){
		parent::__construct();
		$this->model = new PageModel();
	}

	public function get($data){
		$data = implode(' ',$data);
		$this->response($this->model->get($data));
	}

	public function post(){
		$data = $_POST;
		$this->response($this->model->open($data));
	}
}