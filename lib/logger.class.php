<?php
require('error.php');
require('mysql.class.php');
require('getwhois.class.php');

function throwException($message = null,$code = null) {
    throw new Exception($message,$code);
}

class Logger {
	
	/*
	 * Our purpose is to collect data, and format it into an array only! Then we pass it to xmlWrite!
	 * @todo at get_browser() support.
	 */
	
	function collect($feature) { 
		$collection  = array(
		'ip' => $_SERVER['REMOTE_ADDR'],
		'feature' => $feature);
		/*print "<pre>";
		print_r($collection);
		print "</pre>";*/
		return $collection;
	}
	function execute($feature) {
		$data = $this->collect($feature);
		
		$this->whois = new IPData;
		$geoTag = $this->whois->locateIP($data['ip']);
		$this->mysql = new Mysql;
		
		$this->mysql->connect()->selectDB();
		mysql_query("INSERT INTO `eclipseLog` (`ip`, `feature`, `location`
			) VALUES (
				'".$data['ip']."', '".$data['feature']."', '" . $geoTag['city'] . ", " . $geoTag['region_name'] . "');
		") or throwException('MYSQL ERROR');
		
	}
	function recentlyDownloaded($ip) {
		// prolly will never work.
	}
	
}

?>
