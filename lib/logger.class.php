<?php
require('xmlWrite.class.php');


class Logger {
	
	/*
	 * Our purpose is to collect data, and format it into an array only! Then we pass it to xmlWrite!
	 * @todo at get_browser() support.
	 */
	
	function collect($feature) { 
		$feature = array(
		'name' => $feature);
		$collection  = array(
		'agent' => $_SERVER['HTTP_USER_AGENT'],
		'ip' => $_SERVER['REMOTE_ADDR'],
		'feature' => $feature);
		$collection = array('0' => $collection);
		/*print "<pre>";
		print_r($collection);
		print "</pre>";*/
		return $collection;
	}
	function execute($feature) {
		$data = $this->collect($feature);
		$xmlwriter = new XMLWrite($data);
		
		$xmlwriter->write();
	}
	function recentlyDownloaded($ip) {
		// prolly will never work.
	}
	
}

?>
