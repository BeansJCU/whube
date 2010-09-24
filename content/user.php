<?php

$p = $PROJECT_OBJECT;
$b = $BUG_OBJECT;
$u = $USER_OBJECT;

$u->getByCol( "username", $argv[1] );
$user = $u->getNext();

$RIGHTS_OBJECT->getAllByPK( $user['uID'] );
$user_rights = $RIGHTS_OBJECT->getNext();

$projects = $p->userMembership( $user['uID'] );

$b->getByCol( "package", $user["uID"] ); // this is goddamn awesome
$booboos = $b->numrows();


$critical = -1; // doh // $b->specialSelect( "bug_status != 1" );

if ( isset ( $user["username"] ) ) {

	$projectList = "";

	$i=0;
	foreach ( $projects as $projectski ) {
		$project = $p->getName( $projectski['projectID'] );
		$projectList .= "<li><a href='" . $SITE_PREFIX . "t/project/" . $project['project_name'] . "'>" . $project['project_name'] . "</a></li>";
		$i++;
	}
  
	$TITLE = $user["username"] . ", one of the fantastic users on Whube";
	$CONTENT = "
<h1>" . $user["username"] . "</h1>
This here be " . $user['real_name'] . "<br />

There are " . $booboos . " bugs filed by " . $user['username'] . ". " . $critical . " are critical.<br />
<br />

" . ucwords($user['username']) ." is a member of " . sizeof($projects) . " projects. These projects are: 
<ul>" . $projectList . "</ul>
";
} else {
	$_SESSION['err'] = "User " . $argv[1] . " does not exist!";
	header( "Location: $SITE_PREFIX" . "t/home" );
	exit(0);
}

?>
