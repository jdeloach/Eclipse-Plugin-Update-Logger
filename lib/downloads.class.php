<?php 
require('mysql.class.php');

class Downloads {
	
	function __construct($feature=null) {
		$this->feature = $feature;
		$this->mysql = new Mysql;
		$this->mysql->connect()->selectDB();
	}
	public function getFeatures() {
		$features = array();
		if($handle = opendir('features/')) {
			while(false !== ($file = readdir($handle))) {
				if($file != "." && $file != "..") {
					array_push($features, $file); 
				}
			}
			closedir($handle);
		}
		return $features;
	}
	public function getFeaturesCount($features) {
		$i = 0;
		$amount = array();
		while ( $row = $features[$i] ) {
			$row = explode('.jar', $row);
			$row = $row[0];
			$matches = mysql_query("SELECT * FROM `eclipseLog` WHERE feature = '" . $row ."'");
			$count = mysql_num_rows($matches);
			array_push($amount, $count);
			$i++;
		}
		return $amount;
	}
	function getLog() {
		$verNum = explode('_', $this->feature);
		$verNum = $verNum['1'];
//		print $verNum;  LIKE '%".$this->feature."%'
		$query = mysql_query("SELECT * FROM `eclipseLog` WHERE feature = '".$this->feature."'");
		return $query;
	}
	function format() {
		$array = $this->getLog();
		/*while ($d = mysql_fetch_array($array)) {
			if (preg_match('/(\d+\.\d+)/',, $matches) || preg_match('/(\d+)/', $str, $matches) ) {
				echo $matches[1];
			}
		}*/
		
		print "<h2>".$this->feature."</h2><br />";
		print "This has been downloaded ".mysql_num_rows($array)." times!";
		while ($d = mysql_fetch_array($array)) {
			
		}
		print "</table>";
	}
	
	
}
if(isset($_GET['f'])) {
$admin = new Downloads($_GET['f']);
$admin->format();
}
//$admin->displayFeaturesList();
?>
 