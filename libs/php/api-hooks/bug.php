<?php
/*

$d['errors'] = true;
$d['success'] = false;
$d['message'] = "Unknown error";

*/

function handleBugRequest( $argv ) {
	$ret     = array();
	$f       = array();

/*
URES		bID
RESOLVE		bug_status
RESOLVE		bug_severity
RESOLVE		package
RESOLVE		reporter
RESOLVE		owner
UNRES		title
UNRES		descr
UNRES		startstamp
UNRES		trampstamp
WARN		private
*/

	$ret['message'] = $frobber;
	$ret['errors']  = false;
	$ret['success'] = true;

	return $ret;
}

$hooks['bug'] = "handleBugRequest";

?>
