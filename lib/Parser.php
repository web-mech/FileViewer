<?php
/**
  * This class is responsible for parsing text files into html.
  *
  * This class contains several methods that parse particular parts of a text document. Sort of a markdown parser.
  *
  * @author  Michael Price <webmech@gmail.com>
  *
  * @since 1.0
  *
  * @param array $content Content to be parsed.
  */
class Parser{
	protected $content;
	protected $contentType;
	protected $type;
	protected $path; 
	protected $title;

	public function __construct($content){
		$this->type = $content['type'];

		if($this->type =='file'){
			$this->path = $content['path'];
			$this->contentType = pathinfo($content['name'], PATHINFO_EXTENSION);
		}

		if($this->type == 'db'){
			$this->content = $content['text'];
			$this->contentType = $content['mime'];
		}

		$this->title = $content['name'];
	}

	public function parse(){
		if($this->type == 'file'){
			return $this->parseFile();
		}

		if($this->type = 'db'){
			return $this->parseEntry();
		}
	}

	private function parseFile(){
		$this->content = file_get_contents($this->path);
		
		if($this->contentType == 'html'){
			return $this->document();
		}

		return $this->findLists()
					->findParagraphs()
					->findHeaders()
					->findTitles()
					->findEmails()
					->findUrls()
					->document();
	}

	private function parseEntry(){
		if($this->contentType == 'text/html'){
			return $this->document();
		}

		return $this->findLists()
					->findParagraphs()
					->findHeaders()
					->findTitles()
					->findEmails()
					->findUrls()
					->document();
	}

	private function findEmails(){
		$this->content = preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', '<a href="mailto:$1">$1</a>', $this->content);
		return $this;
	}

	private function findUrls(){
		$this->content = preg_replace('%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s','<a href="$1">$1</a>',$this->content);
		return $this;
	}

	private function findLists(){
		$lines = explode("\n",$this->content);
		$lists = array();
		$list = array();

		foreach($lines as $k=>&$v){
			if((substr($v,0,1) == '*' && substr($v,1,1) != "*") || (substr($v,0,1) == '-' && substr($v,1,1) != "-")){
				if(count($list) == 0){
					$list[0] = $k;
				}

				$v = "<li>".substr($v,1,strlen($v)-1);

				if(preg_replace("/\s/","\t",substr($lines[$k+1],0,1)) == "\t"){
					continue;		
				}

				$v = $v."</li>";

				continue;
			}

			if(preg_replace("/\s/","\t",substr($v,0,1)) == "\t"){
				if(preg_replace("/\s/","\t",substr($lines[$k+1],0,1)) == "\t"){
					continue;		
				}
				$v = $v."</li>";
				continue;	
			}

			$list[1] = $k;
			
			if(count($list)>0){
				$lists[] = $list;
				$list = array();
			}
		}

		foreach($lists as $k=>$list){
			$lines[$list[0]] = "<ul>".$lines[$list[0]];
			$lines[$list[1]] = $lines[$list[1]]."</ul>";
		}

		$this->content = implode("\n",$lines);

		return $this;
	}

	private function findParagraphs(){
		$lines = explode("\n",$this->content);

		foreach($lines as $k=>&$v){
			if(empty($v)){
				$prevLine = preg_replace("/[^a-zA-Z0-9]+/", "", substr($lines[$k-1],0,1));
				$nextLine = preg_replace("/[^a-zA-Z0-9]+/", "", substr($lines[$k+1],0,1));
				
				if(!empty($nextLine)){
					$v = '<p>';
				}
					
				if(!empty($prevLine)){
					$v = '</p>';
				}
					
			}
		}

		$this->content = implode("\n",$lines);

		return $this;
	}

	private function findHeaders(){
		$lines = explode("\n",$this->content);

		foreach($lines as $k=>&$v){
			$hl = 0;
			for($i=0;$i<strlen($v);$i++){
				if(substr($v,$i,1) == '#'){
					$hl = $i+1;
				}
			}

			if($hl > 0 && $hl < 7){
				$v = "<h$hl>".str_replace("#","",$v)."</h$hl>";
			}
		}

		$this->content = implode("\n",$lines);

		return $this;
	}

	private function findTitles(){
		$lines = explode("\n",$this->content);

		foreach($lines as $k=>&$v){
			if(substr($v,0,2) == '--' || substr($v,0,2) == '=='){
				$v = '';
				$this->title = strip_tags($lines[$k-1]);
				$lines[$k-1] = "<h1>".$lines[$k-1]."</h1>";
			}
		}

		$this->content = implode("\n",$lines);

		return $this;
	}

	private function document(){
		$lines = explode("\n",$this->content);
		$this->content = implode("",$lines);
		return array("content"=>$this->content,"title"=>$this->title);
	}
}