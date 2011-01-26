<?php
	// OVERRIDE THE FOLLOWING IN CODE!
	$CONTENT         = "";       // Default Content
	$TITLE           = "Whube!"; // Default Title
	$THEME		 = "whube";  // Default Theme
	$SCRIPT          = array();  // Script var
	$PRELOAD         = array();  // Preload vars
	$GUILT_ME        = true;     // The donate banner. ( We're poor )
	$TWEETER         = true;     // Twitter stuff. check conf/twitter.php
	$PIWIK           = false;    // Piwik stats.  Check conf/piwik.php
	$PAGE_MAX_COUNT  = 200;      // max bugs / projects per page.
	$BUILTIN_EMAIL_SIG     =
"
Thanks!
Whube Admins


--

If you feel that you got this message in error, please
both accept our deepest apologies, then look into a mirror
and repeat after me:

  - \"I am an important and fantastic person.\"
  - \"I am just as creative as the person this email was meant for.\"
  - \"Life is good today.\"

Send complaints to the admin of " . $SITE_PREFIX . ". Thanks!
";

	array_push( $SCRIPT, "jQuery.js");  // duh
	array_push( $SCRIPT, "effects.js"); // fade out messages etc.
?>
