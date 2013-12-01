<?php
/**
  * A Simple Rest Controller.
  * 
  * This rest controller detects the request method and attempts to execute the corresponding action.
  *
  * @author Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  */
class Rest extends Controller{
	protected $requestType;
	protected $putVars;
	protected $deleteVars;
	protected $postVars;

	public function __construct(){
		$this->config = new Config();
	}

	public function request($data){
		$requestType = strtolower($_SERVER['REQUEST_METHOD']);
		if(method_exists($this,$requestType)){
			$this->$requestType($data);
			return;
		}

		throw new Exception("Unsupported Request $requestType");
	}

	public function post($data){
		$this->response(array("Not Implemented"));
	}

	public function put($data){
		$this->response(array("Not Implemented"));
	}

	public function get($data){
		$this->response($data);
	}

	public function delete($data){
		$this->response(array(1=>"Not Implemented"));
	}

	private function _getVars(&$outObj){
		parse_str(file_get_contents("php://input"),$outObj);
	}

	protected function response($data){
		header("Content-Type: application/json");
		echo json_encode($data);
	}
}