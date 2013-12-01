<?php
/**
  * Wrapper class for mysqli. 
  *
  * This class is primarily used by the models instances. Used to make database interactions.
  *
  * @author  Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  *
  * @todo Add result cleanup.
  */
class DB extends mysqli {
	
	private $link;

	protected $lastInsertId;

	protected $_query;

	public function __construct(){
		$this->config = new Config();
		
		//try to connect
		parent::__construct($this->config->host, $this->config->user, $this->config->pass,$this->config->db);
		
		//notify if i fail
		if ($this->connect_error) {
		    die('Connect Error (' . $this->connect_errno . ') ' . $this->connect_error);
		}
		
		$this->set_charset("utf8");

		return $this;
	}

	public function get($table,$fields=array('*')){
		$this->_query = sprintf('select %s from %s',implode(",",$fields),$table);
		return $this;
	}

	public function where($query=array()){
		$query = implode(' ',$query);
		$this->_query = sprintf('%s where %s',$this->_query,$query);
		return $this;
	}

	public function result(){
		if($result = $this->query($this->_query)){
			return $result;
		}else{
			return $this->error;
		}
	}

	public function resultObjectArray(){
		$objArray = array();
		if ($result = $this->query($this->_query)) { 
	        while($obj = $result->fetch_object()){
	            $objArray[] = $obj;
	        } 
	    }else{
	    	return $this->error;
	    }
	    return $objArray; 
	}

	public function resultAssocArray(){
		$assocArray = array();
		if ($result = $this->query($this->_query)) { 
	        while($obj = $result->fetch_assoc()){ 
	            $assocArray[] = $obj;
	        } 
	    }else{
	    	return $this->error;
	    }
	    return $assocArray; 
	}
}