<?php
require('mysql.class.php');

class ExportCSV {

	function __construct() {
		$mysql = new Mysql();
		$mysql->connect() or die('Could not connect!');
		$mysql->selectDB();
		$this->table = 'eclipseLog';
		$this->file = 'export';
	}

	private function getData() {
		$result = mysql_query("SHOW COLUMNS FROM ".$this->table."");
		$i = 0;
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
				$this->csv_output .= $row['Field']."; ";
				$i++;
			}
		}
		$this->csv_output .= "\n";
		$values = mysql_query("SELECT * FROM ".$this->table."");
		while ($rowr = mysql_fetch_row($values)) {
			for ($j=0;$j<$i;$j++) {
				$this->csv_output .= $rowr[$j]."; ";
			}
			$this->csv_output .= "\n";
		}
	}
	private function writeFile() {
		$filename = $this->file."_".date("Y-m-d_H-i",time());
		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header( "Content-disposition: filename=".$filename.".csv");
		print $this->csv_output;
		exit;
	}
	public function main() {
		$this->getData();
		$this->writeFile();
	}
}
$exporter = new ExportCSV();
$exporter->main();
?>