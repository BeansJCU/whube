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

			$_SESSION['msg'] = "Don'tcha wish your comment was hot like me?";
			header("Location: $SITE_PREFIX" . "t/bug/$pname");
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
