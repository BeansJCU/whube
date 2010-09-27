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
isset ( $_POST['bug']  ) &&
isset ( $_POST['descr'])
	) {
		include( $app_root . "model/user.php" );
		include( $app_root . "model/bug.php" );
		include( $app_root . "model/bug_comment.php" );

		$b = $BUG_OBJECT;
		$u = $USER_OBJECT;

		$pname = htmlentities( $_POST['bug'],     ENT_QUOTES);
		$descr = htmlentities( $_POST['descr'],   ENT_QUOTES);

		$b->getAllByPK( $pname );
		$bug = $b->getNext();

		if ( $bug != NULL && $bug['bID'] > 0 ) {
			$fields = array(
				"bugID"    => clean($pname),
				"ownerID"  => clean($_SESSION['id']),
				"blahblah" => clean($descr)
			);
			$id = $BUG_COMMENT_OBJECT->createNew( $fields );

			if ( $BUILTIN_EMAIL_ENABLE ) {

$person_queue = array();

$USER_OBJECT->getAllByPK( $bug['reporter'] );
$reporter = $USER_OBJECT->getNext();

$PROJECT_OBJECT->getAllByPK( $bug['package'] );
$package = $PROJECT_OBJECT->getNext();

$hackers = $PROJECT_OBJECT->userMembership( $package['pID'] );

foreach( $hackers as $hacker ) {
	$person_queue[$hacker['userID']] = 'team member';
}

$person_queue[$package['owner']] = 'owner';
$person_queue[$reporter['uID']]  = 'reporter';

foreach( $person_queue as $value => $key ) {
	$USER_OBJECT->getAllByPK($value);
	$person = $USER_OBJECT->getNext();

	if ( isset ( $person['uID'] ) ) {

$message = "Shalom, " . $person['real_name'] . "

Someone just filed a comment against " . $package['project_name'] . "[1].


You're recieving this bug because you are a " . $key . " on this bug.


== Links below this point ==

[1]: " . $SITE_PREFIX . "t/project/" . $package['project_name'] . "
[2]: " . $SITE_PREFIX . "t/bug/" . clean($pname) . "

" . $BUILTIN_EMAIL_SIG;

$title = "New comment against ( bug #" . clean($pname) . " )";

	 	sendEmail( $BUILTIN_EMAIL_ADDR, $person['email'], $title, $message );
	}
}
			}
			$_SESSION['msg'] = "Don'tcha wish your comment was hot like me?";
			header("Location: $SITE_PREFIX" . "t/bug/" . $pname);
			exit(0);
		} else {
			$_SESSION['err'] = "That's not a real bug!!";
			header("Location: $SITE_PREFIX" . "t/bug-list");
			exit(0);
		}
	} else {
		$_SESSION['err'] = "Please fill in all the forms!";
		header("Location: $SITE_PREFIX" . "t/bug-list");
		exit(0);
	}

?>
