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
			<th>Bug Title</th>
		</tr>
";
	while ( $row = $BUG_OBJECT->getNext() ) {
		$status = getStatus( $row['bug_status'] );
		$severity = getSeverity( $row['bug_severity'] );

		$CONTENT .=
"
		<tr style=\"cursor:pointer\" onclick=\"document.location.href = '" . $SITE_PREFIX . "t/bug/" . $row['bID'] . "'\" >
			<td>" . $row['bID'] . "</td>
			<td>" . $row['package'] . "</td>
			<td>" . $status['status_name'] . "</td>
			<td>" . $severity['severity_name'] . "</td>
			<td><a href = \"" . $SITE_PREFIX . "t/bug/" . $row['bID'] . "\">" . $row['title'] . "</a></td>
		</tr>
";
	}

	$CONTENT .=
"
	</table>
";

}

?>
