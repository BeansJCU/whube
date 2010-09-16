<?php

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

$TITLE = "Latest $Count bugs";

$i = 0;

$CONTENT .= "<h1>Last $Count bugs filed</h1>";

$bugs = $BUG_OBJECT->getAllBugs();
$CONTENT .= bugList( $Count, $bugs );

?>
