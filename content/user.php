<?php
	$p = $PROJECT_OBJECT;
	$b = $BUG_OBJECT;
	$u = $USER_OBJECT; // precretaed objects

	$u->getByCol( "username", $argv[1] ); // get the /t/%s
	$user = $u->getNext(); // get the first result.

	$RIGHTS_OBJECT->getAllByPK( $user['uID'] ); // get rights for the user
	$user_rights = $RIGHTS_OBJECT->getNext();

	$projects = $p->userMembership( $user['uID'] ); // get their team membership

	$b->getByCol( "owner", $user["uID"] ); // get all bugs owned by said person
	$booboos = $b->numrows();


	$critical = -1; // XXX: Fixme! doh // $b->specialSelect( "bug_status != 1" );

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
