<?php 
$dbUser = readline("MySQL username:");

$dbPassword = readline("MySQL password:");

$dbServer = readline("MySQL server:");

$dbName = readline("MySQL database name:");

$gAPI = readline("gAPI key (not required, hit enter if skipping):");

$fh = fopen("config.php", 'w') or die('Can\'t open/create file config.php');
fwrite($fh, "<?php\r\n");
fwrite($fh, '$dbUser = \'' . $dbUser . "';\r\n");
fwrite($fh, '$dbPassword = \'' . $dbPassword . "';\r\n");
fwrite($fh, '$dbServer = \'' . $dbServer . "';\r\n");
fwrite($fh, '$dbName = \'' . $dbName . "';\r\n");
fwrite($fh, '$gAPI  = \'' . $gAPI . "';\r\n");

fclose($fh);


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
print "Successfully re-installed MySQL table";
?>
