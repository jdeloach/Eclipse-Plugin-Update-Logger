<?php 
require('xml2array.class.php');

class Admin {
	
	function __construct() {
	}
	function getLog() {
		$query = xml2array(file_get_contents("logs/log0.xml"));
		return $query;
	}
	function format() {
		$array = $this->getLog();
		$array = $array['log']['download'];
		print "<a href=\"lib/backupLog.class.php\">Download list as CSV ( Excel )</a><br />";
		print "<a href=\"?clear\">Clear this List</a>";
		print "<table width=\"700px\" border=\"1\" cellspacing=\"3\" cellpadding=\"3\" style='background-color: #CDCDCD;' border='#FFF'>\n";
		print "<tr>\n";
		print "<th width='4%'>#</th>\n";
		print "<th width='19%'>IP</th>\n";
		print "<th width='27%'>Date</th>\n";
		print "<th width='29%'>Location</th>\n";
		print "<th width='21%'>Features</th>\n";
		print "<th width='5%'></th>\n";
		$loc = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$loc = explode('?', $loc);
		$url = $loc['0'];
		$i = 0;
		date_default_timezone_set('America/Chicago');
		for($i = 0; $i < count($array); $i++) {
			$d = $array[$i];
			$date = (string) $d['date'];
			if($i % 2)
				$bgColor = "FFFFFF"; // color 1
			else
				$bgColor = "C0C0C0"; //color 2

			print "<tr bgcolor='" . $bgColor  . "'>\n";
			print "<td>" . $d['id'] . "</td>\n";
			print "<td><a href='whois.php?ip=" . $d['ip'] . "'>" . $d['ip'] . "</a></td>\n";
			print "<td>" . date('M j, Y g:i a', strtotime($date)) . "</td>\n";
			print "<td>" . $d['location'] . "</td>\n";
			print "<td><a href='lib/downloads.class.php?f=" . $d['feature']['name'] . "'>" . $d['feature']['name'] . "</td>\n";
			print "<td><a href='?delete=" . $d['id'] . "'>Delete</a></td>\n";
			print "</tr>\n";
		}
		print "</table>";
	}
	
	
}
$admin = new Admin();
$admin->format();
?>
