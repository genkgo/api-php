<?php
namespace Genkgo\Api;

class GenkgoApi {
	protected $location,$apitoken;
	public $debug = false;
	
	public function __construct ($location,$token) {
		$this->location = $location;
		$this->apitoken = $token;
	}
	
	public function command ($part,$command,$parameters=array()) {
		if ($this->debug) {
			error_reporting(-1);
		}
		$data = array(
			'part'		=> (string) $part,
			'command'	=> (string) $command,
			'token'		=> (string) $this->apitoken
		);
		$data = array_merge($data,$parameters);
		return $this->post(http_build_query($data));
	}
	
	protected function post ($data) {
		$url = parse_url($this->location);
		$opts = array(
			'http' => array (
				'method' 	=> 'POST',
				'header'	=> "Content-type: application/x-www-form-urlencoded\r\n",
				'ignore_errors' 	=> true,
				'content' 	=> $data
			)
		);
		$context = stream_context_create($opts);
		$l = $url['scheme'].'://'.$url['host'].$url['path'];
		$this->log("Request",$l);
		$fp = fopen($l, 'r', false, $context);
		if ($fp) {
			$headers = stream_get_meta_data($fp);
			$content = stream_get_contents($fp);
			fclose($fp);
			
			$status = substr($headers['wrapper_data'][0],0,12);
			if ($status=='HTTP/1.1 200') {
				$this->log("Content",$content);
				return json_decode($content);
			} elseif ($status=='HTTP/1.1 401') {
				$this->log("Wrong API token",$content);
				return false;
			} elseif ($status=='HTTP/1.1 400') {
				$this->log("Wrong paramaters",$content);
				return false;
			} else {
				$this->log("Server error",$content);
				return false;
			}
		} else {
			throw new Exception('No connection');
		}
	}
	
	protected $log = array();
	
	public function log ($msg,$response=null) {
		$this->log[] = $msg;
		if ($this->debug) {
			echo $msg;
			if ($response) {
				echo ": ".$response."<br />";
			}
		}
	}
	
}
?>