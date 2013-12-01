<?php
/**
  * Base class for all models.
  *
  * This class is the parent class for all models. It simply invokes a ready instance of the DB class and loads a local config instance.
  *
  * @author Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  */
class Model{
	protected $table;

	protected $db;

	public function __construct(){
		$this->db = new DB();
		$this->config = new Config();
	}
}