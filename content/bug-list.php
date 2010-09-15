<?php

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

if ( isset( $argv[2] ) ) {
	$class = htmlentities($argv[1], ENT_QUOTES);
	$id    = htmlentities($argv[2], ENT_QUOTES);
}

$TITLE = "Latest $Count bugs";

$i = 0;

$CONTENT .= "<h1>Last $Count bugs filed</h1>";

$bugs = $BUG_OBJECT->getAllBugs();
$CONTENT .= bugList( $Count, $bugs );

?>
