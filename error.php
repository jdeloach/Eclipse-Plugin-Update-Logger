<?php
error_reporting(E_ALL);
function handleError($errno, $errstr, $error_file, $error_line) {
	$time = date('r');
		
	$to = ''; //TO
	$subject = "Eclipse Update Site FAILURE";
	$message = "To whom it may concern, \n";
	$message .= "It would appear that the Update logger has failed.\n";
	$message .= "It has done it\'s best to shut off the system, but no promises.\n";
	$message .= "Reminder, to shut it off, just change the name of .htaccess!\n";
	$message .= "Here is some data to prove it!\n";
	$message .= "And the time was ".$time."\n";
	$message .= "PHP\'s turn!:\n";
	$message .= '$errno: '.$errno."\n";
	$message .= '$errstr: '.$errstr."\n";
	$message .= '$error_file: '.$error_file."\n";
	$message .= '$error_line: '.$error_line."\n";
	$message = wordwrap($message, 70);
		
	mail($to, $subject, $message) or die('Life sucks... were broken and we can\'t even tell our Sysadmins about it... ') or die('Failed to mail');
	print "Problem identified, administrators have been emailed. Thank you.";
}
set_error_handler("handleError");
?>
