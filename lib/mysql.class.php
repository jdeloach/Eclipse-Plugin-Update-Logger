<?php
require('../config.php') or die('You need to create a config.php in the update root dir!');
 define('DEFAULT_MYSQL_SERVER', $dbServer);
 define('DEFAULT_MYSQL_USER', $dbUser);
 define('DEFAULT_MYSQL_PASSWORD', $dbPassword);
 
 
 
class Mysql
{
	function __construct() {
	}
	function connect($user=NULL, $password=NULL, $server=NULL)
	{
		if(isset($user)) {
			$user = $user;
		}else{
			$user = DEFAULT_MYSQL_USER;
		}
		if(isset($password)) {
			$password = $password;
		}else{
			$password = DEFAULT_MYSQL_PASSWORD;
		}
		if(isset($server)) {
			$server = $server;
		}else{
			$server = DEFAULT_MYSQL_SERVER;
		}

		mysql_connect($server, $user, $password);
		return $this;
	}
	function disconnect()
	{
		mysql_close();
	}
	function ping()
	{
		mysql_ping();
	}
	function selectDB($db=NULL)
	{
		if(isset($db)) mysql_select_db($db);
		if(!isset($db)) mysql_select_db($dbName);
	}
	function query($query)
	{
		return mysql_query($query);
	}
	function num_rows($result)
	{
		return mysql_num_rows($result);
	}
	function fetch_array($result, $result_type=MYSQL_BOTH)
	{
		return mysql_fetch_array($result, $result_type);
	}
}
