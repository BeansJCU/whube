<?php
    /*
     *  License:     AGPLv3
     *  Author:      Paul Tagliamonte <paultag@whube.com>
     *  Description:
     *    Global Routines
     */

$php_root = dirname(  __FILE__ ) . "/";

include( $php_root . "../../model/sql.php" );
include( $php_root . "../../model/user.php" );
include( $php_root . "../../model/bug.php" );
include( $php_root . "../../model/project.php" );

$JS_ROOT = $php_root . "../js/";

function useScript( $id ) {
	global $SCRIPT, $JS_ROOT;
	if ( file_exists( $JS_ROOT . $id ) ) {
		array_push( $SCRIPT, $id );
	}
}

function sendEmail( $from, $to, $subject, $message ) {
    $headers = 'From: ' . $from . "\r\n";
    mail($to, $subject, $message, $headers);
}

function clean( $ret ) {
	if ( isset( $ret ) ) {
		$ret = addslashes( $ret );
		return htmlentities( $ret, ENT_QUOTES);
	} else {
		return NULL;
	}
}

function format( $ret ) {
	if ( isset( $ret ) ) {
		$ret = stripslashes( $ret );
		$ret = html_entity_decode( $ret, ENT_QUOTES);
		return $ret;
	} else {
		return NULL;
	}
}

function preload( $l, $w, $src ) {
	global $PRELOAD;
	$payload = array();
	$payload['w']   = $w;
	$payload['h']   = $l;
	$payload['src'] = $src;

	array_push( $PRELOAD, $payload );
}

function breakUpLine( $line ) {
	$pos = strrpos($line, "/");
	if ($pos === false) {
		return array($line);
	} else {
		$prefix  = trim(substr( $line, 0, $pos ) );
		$postfix = trim(substr( $line, $pos + 1, strlen( $line )) );
		$prefix  = htmlentities( $prefix,  ENT_QUOTES);
		$postfix = htmlentities( $postfix, ENT_QUOTES);

		$ret = array( $prefix, $postfix );
	}
	return $ret;
}

function requireLogin() {
	global $SITE_PREFIX;
	if ( isset ( $_SESSION['id'] ) && $_SESSION['id'] > 0) {
		return true;
	} else {
		$_SESSION['err'] = "Login before you can hit that page!";
		header("Location: " . $SITE_PREFIX . "t/login" );
		exit(0);
	}
}

function requireLocalIP() {
	global $SITE_PREFIX;
	global $MY_IP;

	$LOCAL = false;

	foreach ( $MY_IP as $KEY ) {
		if ( $_SERVER['REMOTE_ADDR'] == $KEY ) {
			$LOCAL = true;
		}
	}

	if ( $LOCAL ) {
		return true;
	} else {
		$_SESSION['err'] = "You're not local. Error.";
		header("Location: " . $SITE_PREFIX . "t/home" );
		exit(0);
	}


}

function checkBugViewAuth( $bugID, $requester ) {

$b = new bug();
$u = new user();
$p = new project();

$b->getAllByPK( $bugID );
$bug = $b->getNext();

if ( isset( $bug['bID'] ) ) {
	if ( isset($_SESSION['patrick_stewart']) && $_SESSION['patrick_stewart'] ) { // see gate for context
		return array( true, $bug['private'] ); // public bug, dummy
	}

	$whoami = $requester;

	if ( $bug['private'] ) {
		// good query.
		$u->getAllByPK( $bug['owner'] );
		$owner = $u->getNext();
		$u->getAllByPK( $bug['reporter'] );
		$reporter = $u->getNext();
		$p->getAllByPK( $bug['package'] );
		$project = $p->getNext();

		$oid = -10000;
		$rid = -10000;
		$pid = -10000;

		if ( isset ( $owner['uID'] ) )    { $oid = $owner['uID'];    }
		if ( isset ( $reporter['uID'] ) ) { $rid = $reporter['uID']; }
		if ( isset ( $project['oID'] ) )  { $pid = $project['oID'];  }

		if (
			$oid != $whoami &&
			$rid != $whoami &&
			$pid != $whoami
		) {
			return array( false, $bug['private'] );
		} else {
			return array( true, $bug['private'] );
		}

	} else {
		return array( true, $bug['private'] ); // public bug, dummy
	}
} else {
	return array( false, false ); // bug iz no good
}

/* 

if bug.private:
	check if is owner
	check if is reporter
	check if is asignee
	check if is project owner
	check if site administrator / staff

	any of the above: Yes, otherwise, no
else:
	Yes


Query bug, if it's public, don't give a shit.


*/

}

function loggedIn() {
	if ( isset ( $_SESSION['id'] ) && $_SESSION['id'] > 0 ) {
		return true;
	} else {
		return false;
	}
}

function getProjectName( $pID ) {
	return executeGet( "projects", "pID", $pID );
}

function getStatus( $status ) {
	return executeGet( "status", "statusID", $status );
}

function getAllStatus() {
	return executeGetAll( "status" );
}

function getSeverity( $severity ) {
	return executeGet( "severity", "severityID", $severity );
}

function getAllSeverity() {
	return executeGetAll( "severity" );
}

function getRights( $id ) {
	return executeGet( 'user_rights', 'userID', $id );
}

/*                          
 * Base Retrieval Functions 
 */
function executeGet( $table_name, $pkcol, $value ) {
	if ( isset ( $value ) ) {
  	global $TABLE_PREFIX;
		$sql = new sql();
		$sql->query( "SELECT * FROM " . $TABLE_PREFIX . $table_name . " WHERE " . $pkcol . " = " . $value . ";" );
		$ret = $sql->getNextRow();
		return $ret;
	}
}

function executeGetAll( $table_name ) {
  global $TABLE_PREFIX;
	$sql = new sql();
	$sql->query( "SELECT * FROM " . $TABLE_PREFIX . $table_name . ";" );
	$ret = array();
	while ( $row = $sql->getNextRow() ) {
		array_push( $ret, $row );
	}
	return $ret;
}

?>
