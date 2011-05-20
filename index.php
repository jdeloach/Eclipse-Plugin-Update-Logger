<?php
session_start();
require('config.php');
$pwd = $GLOBALS['pwd'];
#require('error.php');
require('lib/.users.php');
require('lib/auth.class.php');
$auth = new Auth($users);

if(isset($_GET['logout'])) {
	$auth->logout();
	print '<meta http-equiv="refresh" content="0;url='.$pwd.'?login">';
}
if(isset($_POST['user'])) {
	if($auth->login($_POST['user'], $_POST['passwd'])) {
		print '<meta http-equiv="refresh" content="0;url='.$pwd.'">';
	}else{
		print $auth->error();
	}
}
if(isset($_GET['login'])) {
	require('static/html/login.html');
}
if($auth->is_logged()) {
if(isset($_GET['downloads'])) {
require('static/html/downloads.html');
}elseif((isset($_GET['turnon'])) OR (isset($_GET['addUser'])) OR (isset($_GET['turnoff']))) { 
require('static/html/config.html'); 
}elseif((isset($_GET['clear'])) OR (isset($_GET['delete']))) {
require("static/html/clear.html"); 
}elseif(isset($_GET['config']) && $auth->is_logged()) {
	require('static/html/config.html');
}elseif($auth->is_logged()) {

		require('static/html/main.html');
}
}
if((!isset($_SESSION['logged'])) && (!isset($_GET['login']))) {
	print '<meta http-equiv="refresh" content="0;url='.$pwd.'?login">';
}

?>
