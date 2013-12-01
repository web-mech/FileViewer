<?php
/**
  * Page Model. 
  *
  * This class is responsible for retreiving a list of documents or a single document.
  * 
  * @author Michael Price <webmech@gmail.com>
  * 
  * @since 1.0
  */
class PageModel extends Model {

	public function __construct(){
		parent::__construct();
		$this->table = 'page';	
		$this->parser = new Parser();
		is_dir($this->config->pageDir) or die('No readable page directory found.');
	}

	public function get($name){
		if(empty($name))
			return array();

		$files = $this->getFiles($name);
		$entries = $this->getEntries($name);
		return array_merge($files,$entries);
	}

	private function getFiles($name){
		$files = array();
		if ($handle = opendir($this->config->pageDir)) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		        	if(strpos($entry,$name) !== FALSE){
		        		$files[] = array("name"=>$entry,"type"=>"file","id"=>0);
		        	}
		        }
		    }
		    closedir($handle);
		}
		return $files;
	}

	private function getEntries($name){
		$data = $this->db
					 ->get('link',array('link','page_id'))
					 ->where(array('link','like',"'%$name%'"))
					 ->resultAssocArray();
		$result=array();
		foreach($data as $k=>$v){
			$result[] = array("name"=>$v['link'],"type"=>"db","id"=>$v["page_id"]);
		}
		return $result;
	}

	public function open($page){
		switch($page['type']){
			case 'file':
				return $this->openFile($page);
			break;
			case 'db':
				return $this->openEntry($page);
			break;
		}
	}
	
	private function openFile($file){
		$filePath = $this->config->pageDir . $file['name'];

		if((file_exists($filePath) === false) || (is_readable($filePath) === false)) {
            return array("file"=>$file);
        }
        
        $file['path'] = $filePath;

        $parser = new Parser($file);

        return $parser->parse();
	}

	private function openEntry($entry){
		$data = $this->db
					 ->get($this->table)
					 ->where(array('id','=',$entry['id']))
					 ->resultAssocArray();

		$data = array_merge($data[0],$entry);

		$parser = new Parser($data);

        return $parser->parse();
	}
}