<?php 
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
require('lib/mysql.class.php');
$mysql = new Mysql();
$mysql->connect()->selectDB();
mysql_query($drop);
mysql_query($query);
print "Successfully re-installed MySQL table";
?>