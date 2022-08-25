<?php 
/*
* Author : Savaş Can Altun < savascanaltun@gmail.com >
* Web : http://savascanaltun.com.tr
* Mail : savascanaltun@gmail.com
* GİT : http://github.com/saltun
* Date : 13.06.2015
* Update : 29.06.2016
*/
class sCache {
	private  $cache = null;
	private  $time = 60;
	private  $status = 0;
	private  $dir = "sCache";
	private  $buffer=false;
	private  $start=null;
	private  $load=false;
	private  $external=array();
	private  $type=true;
	private  $extension=".html";
	private  $active=true;
	public function __construct($options=NULL,$active=true){
		$this->active=$active;
		if ($active) {
			if(!defined('S_CACHE_DIRECTORY'))define('SBX_CACHE_DIRECTORY', './sCache'); // Directory where html files are cached.
			if (isset($options)) 
			{
				if (is_array($options)) 
				{
					$this->dir = (isset($options['dir']) ? $options['dir'] : S_CACHE_DIRECTORY);
					$this->buffer = (isset($options['buffer']) ? $options['buffer'] : false);
					$this->time = (isset($options['time']) ? $options['time'] : '120'); // 120 secs.
					$this->load = (isset($options['load']) ? $options['load'] : false); // Load true / false.
					$this->external = (isset($options['external']) ? $options['external'] : array('style.php','colors.php')); // Exclude these from caching.
					$this->extension = (isset($options['extension']) ? $options['extension'] : '.scache'); // File Extension
				}
				else
				{
					die('Options variable acceptable only if in array()');
				}
			}
			$myPage=explode('/',$_SERVER["SCRIPT_FILENAME"]);
			foreach ($this->external as $key => $external) {
				if (in_array(end($myPage), $this->external)) {
					$this->type=false;
					break;
				}
			}
			if ($this->type) {
				if(!file_exists(dirname(__FILE__)."/".$this->dir)){
					mkdir(dirname(__FILE__)."/".$this->dir, 0777);
				}
				if ($this->load) {
						list($time[1], $time[0]) = explode(' ', microtime());
						$this->start = $time[1] + $time[0];
				}
				 $this->cache  =  dirname(__FILE__)."/".$this->dir."/".md5($_SERVER['REQUEST_URI']).$this->extension;
				 if(time() - $this->time < @filemtime($this->cache)) { 
				      readfile($this->cache); 
				      $this->status=1;
				      die();
				}else { 
			      @unlink($this->cache); 
				  ob_start();
				}
			}
		}
	}
	private function buffer($buffer){
		$search = array(
			'/\>[^\S ]+/s',     // strip whitespaces after tags, except space
			'/[^\S ]+\</s',     // strip whitespaces before tags, except space
			'/(\s)+/s',         // shorten multiple whitespace sequences
			'/<!--(.|\s)*?-->/' // Remove HTML comments
		);
		$replace = array(
			'>',
			'<',
			'\\1',
			''
		);
		$buffer = preg_replace($search, $replace, $buffer);
		return $buffer;
	}
	
	private function writeCache($content){
		$file = fopen($this->cache, 'w');
		//$content=$content."<!--- sCache Class - ".$this->time." Second -->";
		@fwrite($file, $content);
		fclose($file);
	}
	public function clearCache(){
		$dir = opendir($this->dir); 
		while (($file = readdir($dir)) !== false) 
		{
		if(! is_dir($file)){
		  unlink($this->dir."/".$file);
		}}
		closedir($dir); 
	}
	public function __destruct(){
		if ($this->active) {
				if ($this->type) {
						if ($this->status==0) {
							if ($this->buffer) {
								$this->writeCache($this->buffer(ob_get_contents()));
							}else{
								$this->writeCache(ob_get_contents());
							}
						}
						if ($this->load) {
								header('Access-Control-Allow-Origin: *');
								header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
								list($time[1], $time[0]) = explode(' ', microtime());
								$finish = $time[1] + $time[0];
								$total_time = number_format(($finish - $this->start), 6);
								echo "Load Time (S) :  {$total_time} ";
						}
						ob_end_flush();
				}
		}
	}
}