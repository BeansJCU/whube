<?php
    /*
     *  License:     AGPLv3
     *  Author:      Paul Tagliamonte <paultag@whube.com>
     *  Description:
     *    You POST against this file
     */
session_start();

$app_root        = dirname(  __FILE__ ) . "/../../";

include( $app_root . "conf/site.php" );
include( $app_root . "libs/php/globals.php" );

requireLogin();

	if (
isset ( $_POST['project'] ) &&
isset ( $_POST['title']   ) &&
isset ( $_POST['descr']   )
	) {
		include( $app_root . "model/user.php" );
		include( $app_root . "model/project.php" );
		include( $app_root . "model/bug.php" );

		$b = new bug();
		$u = new user();
		$p = new project();

		// let's first verify the project.

		$pname = htmlentities( $_POST['project'], ENT_QUOTES);
		$title = htmlentities( $_POST['title'],   ENT_QUOTES);
		$descr = htmlentities( $_POST['descr'],   ENT_QUOTES);

		$p->getByCol( "project_name", $pname );

		$project = $p->getNext();

		if ( $project != NULL && $project['pID'] > 0 ) {
			$fields = array(
"package"  => $project['pID'],
"reporter" => $_SESSION['id'],
"title"    => $title,
"descr"    => $descr
			);
			$id = $b->createNew( $fields );

$person_queue = array();

$USER_OBJECT->getAllByPK( $project['owner'] );
$manager = $USER_OBJECT->getNext();

$person_queue['reporter'] = $_SESSION['id'];
$person_queue['manager']  = $manager['uID'];


foreach( $person_queue as $key => $value ) {

if ( $BUILTIN_EMAIL_ENABLE ) {

	$USER_OBJECT->getAllByPK($value);
	$person = $USER_OBJECT->getNext();

	if ( isset ( $person['uID'] ) ) {

$message =

"Shalom, " . $person['real_name'] . "

Someone just reported a bug against " . $project['project_name'] . "[1].
This bug ( " . $fields['title'] . " ) will from henceforth be known as #" . $id . "[2].


You're recieving this bug because you are a " . $key . " on this bug.

== Details below this point ==

" . $fields['descr'] . "

== Links below this point ==

[1]: " . $SITE_PREFIX . "t/project/" . $project['project_name'] . "
[2]: " . $SITE_PREFIX . "t/bug/" . $id . "

" . $BUILTIN_EMAIL_SIG;

$title = "New bug ( " . $fields['title'] . " ) against project " . $project['project_name'] . " ( bug #" . $id . " )";
		 	   sendEmail( $BUILTIN_EMAIL_ADDR, $person['email'], $title, $message );
			}
	}
}

			$_SESSION['msg'] = "New bug created!";
			header("Location: $SITE_PREFIX" . "t/bug/$id");
			exit(0);
		} else {
			$_SESSION['err'] = "Please enter a real project!";
			header("Location: $SITE_PREFIX" . "t/new-bug");
			exit(0);
		}
	} else {
		$_SESSION['err'] = "Please fill in all the forms!";
		header("Location: $SITE_PREFIX" . "t/new-bug");
		exit(0);
	}

?>
