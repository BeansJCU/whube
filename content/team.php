<?php

$t = $TEAM_OBJECT;
$b = $BUG_OBJECT;
$u = $USER_OBJECT;

// Would we allow dashes in names?  This strips all dashes and replaces by spaces.

if ( strpos ( $argv[1], '-' ) ) {
	$teamName = str_replace ( '-', ' ', $argv[1] );
}

$t->getByCol( "team_name", $teamName ); // this is goddamn awesome
$row = $t->getNext();

$b->getByCol( "package", $row['pID'] ); // this is goddamn awesome
$booboos = $b->numrows();

$bugCount = 0;
$i = 0;

while ( $i < $booboos ) {
  $bug = $b->getNext();   
  if ( $bug['bug_status'] != 8 ) $bugCount++;
  $i++;
}

$bugsFixed = $booboos - $bugCount;

$critical = 0; // doh // $b->specialSelect( "bug_status != 1" );

if ( isset ( $row['tID'] ) ) {
	$TITLE = $teamName . ", one of the fine teams on Whube";
	$CONTENT = "
<h1>" . $teamName . "</h1>
" . $row['descr'] . "<br />
<br /> " .
$row['team_name'] . " is in charge of " . $booboos . " bugs ( " . $bugCount .  " left, " . $bugsFixed . " fixed, " . $critical . " are critical).";

/*
    if ( $VCS_SITE_ENABLE ) {
    
        $CONTENT .= "<br /><br />\n";
        $CONTENT .= "<h1>Version Control Details</h1>\n";

        $CONTENT .= "This project uses <b>" . $VCS_TYPE . "</b>.<br /><br />\n";
        $CONTENT .= "Feel free to checkout the project with the command: <a href = '" . $VCS_SITE_PREFIX . $row['project_name'] . $VCS_SITE_POSTFIX . "' ><span class = 'code-snip' >" . $VCS_CHECKOUT_CMD . " " . $VCS_CHECKOUT_PATH . $row['project_name'] . $VCS_SITE_POSTFIX . "</span></a><br />";
        $CONTENT .= "";
    }  
*/

} else {
	$_SESSION['err'] = "Team " . $argv[1] . " does not exist!";
	header( "Location: $SITE_PREFIX" . "t/home" );
	exit(0);
}

?>
