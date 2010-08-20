<?php
    /*
     *  License:     AGPLv3
     *  Author:      THomas Martin <tenach@whube.com>
     *  Description:
     *    This is where you POST a new registration
     */
session_start();

$app_root        = dirname(  __FILE__ ) . "/../../";

include( $app_root . "libs/php/globals.php" );
include( $app_root . "conf/site.php" );
include( $app_root . "model/user.php" );
include( $app_root . "model/project.php" );
include( $app_root . "model/events.php" );

if (
	isset ( $_POST['newProject'] ) &&
	isset ( $_POST['projDescr']  )
) {

	$r = $PROJECT_OBJECT;
	$u = $USER_OBJECT;

	// Let's verify!

	$pname	= htmlentities( $_POST['newProject'], ENT_QUOTES);
	$descr  = htmlentities( $_POST['projDescr'],  ENT_QUOTES);
	
	$r->getByCol( "project_name", $pname );
	//$project = $r->getNext();
	$projects = $r->getAllProjects();

	$i=0;
	$numProjects = count( $projects );

	$vproj = TRUE;
	foreach( $projects as $project ) {
		if( $_POST['newProject'] == $project['project_name'] ) {
			$_SESSION['err'] = "Hey hey, whaddya trying to pull? That project's already registered. :|";
			header("Location: $SITE_PREFIX" . "t/new-project");
			$vproj = FALSE;
		}
	}
	
	if( $vproj == TRUE ) {
		$locale = explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
		$fields = array(
			"project_name" => clean($_POST['newProject']),
			"descr"  => clean($_POST['projDescr']),
			"owner"	 => clean($_SESSION['id']),
			"active"	=> '1',
			"startstamp"  => time(),
			"trampstamp"  => time()
		);
		$newproj = $r->createNew( $fields );
		
		if ( $BUILTIN_EMAIL_ENABLE ) {

$message =

"Hey there!

Thanks for registering " . $fields['project_name'] . "!

You're a fantastic person, and this email is to just
to assure you that the administrators over at " . $SITE_PREFIX . "
love you and your contributions very much.

Thanks for feeding another project to the wolves!

" . $BUILTIN_EMAIL_SIG;
		    sendEmail( $BUILTIN_EMAIL_ADDR, $fields['email'], "Welcome to Whube, " . $fields['username'] . "!", $message );
		}

		$_SESSION['msg'] = "All registered! Don'tcha feel like a big kid now?";
		header("Location: $SITE_PREFIX" . "t/project-list");
		exit(0);
	} else {
		$_SESSION['err'] = "Please fill in all the fields!";
		header("Location: $SITE_PREFIX" . "t/new-project");
		exit(0);
	}
}

?>
