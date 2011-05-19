<?php
try {
	require('lib/logger.class.php');
	$logger = new Logger;
	$logger->execute($_GET['f']);
	
	header('Content-Type: application/java-archive ');
	header('Content-Disposition: attachment; filename="'.$_GET['f'].'.jar"');
	header("Content-Transfer-Encoding: binary");
	header('Accept-Ranges: bytes');
	header("Cache-control: private");
	header('Pragma: private');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	$fp=fopen('features/'.$_GET['f'].'.jar', 'r');
	fpassthru($fp);
	fclose($fp);
	exit;
} catch (Exception $e) {
	header('Content-Type: application/java-archive ');
	header('Content-Disposition: attachment; filename="'.$_GET['f'].'.jar"');
	header("Content-Transfer-Encoding: binary");
	header('Accept-Ranges: bytes');
	header("Cache-control: private");
	header('Pragma: private');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	$fp=fopen('features/'.$_GET['f'].'.jar', 'r');
	fpassthru($fp);
	fclose($fp);
	exit;
	/*print $e->getMessage() . "<br />";
	print $e->getCode() . "<br />";
	print $e->getFile() . "<br />";
	print $e->getLine() . "<br />";*/
}

?>