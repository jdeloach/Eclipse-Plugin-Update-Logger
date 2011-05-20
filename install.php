<?php 
$dbUser = readline("MySQL username: ");

$dbPassword = readline("MySQL password: ");

$dbServer = readline("MySQL server: ");

$dbName = readline("MySQL database name: ");

$gAPI = readline("gAPI key (not required, hit enter if skipping): ");

$errors = readline("Email you error reports? (y or n): ");
if($errors == 'y' OR $errors == 'Y') {
	$errorEmail = readline("To what email address should we send the email?: ");
	rename('install/errorOn.php', 'error.php');
} else {
	rename('install/errorOff.php', 'error.php');
}

$rootDir = readline("What is the path to the update dir? (from the web like /update/ or /proj/blank/update/): ");
$userName = readline("First users username: ");
$userPassword = readline("First users password: ");

$fh = fopen("config.php", 'w') or die('Can\'t open/create file config.php');
fwrite($fh, "<?php\r\n");
fwrite($fh, '$dbUser = \'' . $dbUser . "';\r\n");
fwrite($fh, '$dbPassword = \'' . $dbPassword . "';\r\n");
fwrite($fh, '$dbServer = \'' . $dbServer . "';\r\n");
fwrite($fh, '$dbName = \'' . $dbName . "';\r\n");
fwrite($fh, '$gAPI  = \'' . $gAPI . "';\r\n");
if(isset($errorEmail))
	fwrite($fh, '$to = \'' . $errorEmail . "';\r\n");
fwrite($fh, '$pwd = \'' . $rootDir . "';\r\n");
fclose($fh);

require('lib/auth.class.php');
Auth::addUser($userName, $userPassword);

$query = '
CREATE TABLE IF NOT EXISTS `eclipseLog` (
  `id` int(9) NOT NULL auto_increment,
  `ip` varchar(18) NOT NULL,
  `feature` varchar(256) NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `agent` text NOT NULL,
  `location` varchar(256) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
';
$drop = 'DROP TABLE eclipseLog';
require('config.php');
require('lib/mysql.class.php');
$mysql = new Mysql();
$mysql->connect()->selectDB();
mysql_query($drop);
mysql_query($query);
print "Successfully re-installed MySQL table\n";
?>
