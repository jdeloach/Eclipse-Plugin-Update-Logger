
<?php

class Config {

	public function __construct() {
	}
	public static function turnOff() {
		rename('.htaccess', '.htaccess.bak') or die('Failed to turn off, possible it is already off?');
		print "Successfully turned off.";
	}
	public function turnOn() {
		rename('.htaccess.bak', '.htaccess') or die('Failed to turn on... possible it is already on?');
		print "Successfully turned on.";
	}
	public function addUser($user, $passwd) {
		$auth->addUser($user, $passwd);
		print "User successfully added.";
	}
	private function isOn() {
		return file_exists('.htaccess');
	}
	public function main() {
		print 'The config page!! <br />';
		if($this->isOn()) {
			print '<a href=\'?turnoff\'>Turn off the Logger</a><br />';
		} else {
			print '<a href=\'?turnon\'>Turn on the logger</a><br />';
		}
		print '
		<br /><br />Add User:
		<form name="newUser" action="?addUser" method="POST">
		<br />Username: <input type="text" name="userADD" /><br />
		Password: <input type="password" name="passwd" /><br />
		<input type="submit" value="Add" />
		</form>';
	}

}
$config = new Config();

if(isset($_GET['turnon'])) $config->turnOn();
if(isset($_GET['turnoff'])) $config->turnOff();
if(isset($_GET['addUser'])) { $auth->addUser($_POST['userADD'], $_POST['passwd']); print "Successfully added user."; }
if(isset($_GET['config'])) $config->main();
?>