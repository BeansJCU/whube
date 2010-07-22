<?php

include( "model/user.php" );
include( "libs/php/core.php" );

requireLogin();

$TITLE    = "Welcome Home!";

$CONTENT  = "<br /><h1>Heyya, " . $_SESSION['real_name'] . "</h1>Welcome Home.<br /><br /><br />\n";
$CONTENT .= "<br /><h1>Queue Hitlist</h1>\n";
$CONTENT .= "<br />\n";

$BUG_OBJECT->getByCol( "owner", $_SESSION['id'] );

if ( $BUG_OBJECT->numRows() <= 0 ) {

	$CONTENT .= "Nothing here! Great job! You rule! Here's a kitty!<br /><br />";
	$CONTENT .= "<img src = '" . $SITE_PREFIX . "imgs/kittah.jpg' alt = 'kittah' /><br /><br />";


} else {
	$CONTENT .=
"
	<table>
		<tr>
			<th>Bug ID</th>
			<th>Project</th>
			<th>Status</th>
			<th>Severity</th>
		</tr>
";
	while ( $row = $BUG_OBJECT->getNext() ) {
		$status = getStatus($row['bug_status']);
		$severity = getSeverity($row['bug_severity']);

		$CONTENT .=
"
		<tr>
			<td>" . $row['bID'] . "</td>
			<td>" . $row['package'] . "</td>
			<td>" . $status['status_name'] . "</td>
			<td>" . $severity['severity_name'] . "</td>
		</tr>
";
	}

	$CONTENT .=
"
	</table>
";

}

?>
