<?php

include( "model/user.php" );
include( "libs/php/core.php" );

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

requireLogin();

$TITLE    = "Welcome Home!";

$CONTENT  = "<br /><h1>Heyya, " . $_SESSION['real_name'] . "</h1>Welcome Home.<br /><br /><br />\n";
$CONTENT .= "<br /><h1>Queue Hitlist</h1>\n";
$CONTENT .= "<br />\n";

$BUG_OBJECT->getByCol( "owner", $_SESSION['id'] );
$bugs = $BUG_OBJECT->toArray();

if ( sizeof( $bugs ) <= 0 ) {
	$CONTENT .= "Nothing here! Great job! You rule! Here's a kitty!<br /><br />";
	$CONTENT .= "<img src = '" . $SITE_PREFIX . "imgs/kittah.jpg' alt = 'kittah' /><br /><br />";
} else {

	$CONTENT .= bugList( $Count, $bugs );

}

?>
