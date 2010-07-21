<?php
	// This is where you hit the site from outside the app.
	// the HTML will be prefixed with this because of the badass
	// arg system. This is the most critical bit of the conf file.
	$SITE_PREFIX   =   "http://localhost/whube/";

	// This IP is the IP of the server, used by the local API.
	// Most of the time you can get away with localhost or 127.0.0.1
	// but sometimes you might have to tweek me. See how it's used over
	// in localcallback.php.
	$MY_IP         =

	array(
		"127.0.0.1", /* IPv4 */
		"localhost", /* Internal /etc/hosts */
		"::1",       /* IPv6 */
	);

	$DEBUG         =   true;
	
    $BUILTIN_EMAIL_ENABLE  =   true;
    $BUILTIN_EMAIL_ADDR    =   "Automated Bugmail <bugs@whube.com>";

	include( dirname(__FILE__) . "/add-salt.php" ); // add salt to taste
?>
