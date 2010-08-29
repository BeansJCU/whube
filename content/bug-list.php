<?php

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

if ( isset( $argv[2] ) ) {
	$class = htmlentities($argv[1], ENT_QUOTES);
	$id    = htmlentities($argv[2], ENT_QUOTES);
}

$TITLE = "Latest $Count bugs";

$i = 0;

$CONTENT .= "<h1>Last $Count bugs filed</h1>";

$CONTENT .= "
<table class = 'sortable' >
	<tr class = 'nobg' >
		<th>ID</th> <th> Status </th> <th> Severity </th> <th>Owner</th> <th>Project</th> <th>Private</th> <th>Title</th>
	</tr>
";

$p = $PROJECT_OBJECT;
$u = $USER_OBJECT;
$b = $BUG_OBJECT;

$p->getAll();
$u->getAll();
$b->getAll();

$s = 0;

$bugs = $b->getAllBugs();
$bCount = count($bugs);

while ( $s < $bCount ) {
	$row = $bugs[$s];
  $b->getAllByPK( $row['bID'] );
  $u->getAllByPK( $row['owner'] );

  $u->getByCol( 'uID', $row['owner'] );
  $user = $u->getNext();
  
  $p->getByCol( 'pID', $row['package'] );
  $project = $p->getNext();

	if ( $row['bug_status'] == 8 ) {
		$CONTENT .= "";
		$s++;
	} else {

		if ( $user == '' ) {
			$user = '-';
		}

		if ( $row['private'] == 1 ) {
			$private = "Yep";
		} else {
			$private = "No";
		}


		$status   = getStatus(   $row['bug_status']   );
		$severity = getSeverity( $row['bug_severity'] );

		$statusClass   = "goodthings";
		$severityClass = "goodthings";

		$overrideOne = False;
		$overrideTwo = False;

		if ( $status['critical'] ) {
			$statusClass = "badthings";
		}

		if ( $severity['critical'] ) {
			$severityClass = "badthings";
		}

		$CONTENT .= "\t<tr style=\"cursor:pointer\" onclick=\"document.location.href = '" . $SITE_PREFIX . "t/bug/" . $row['bID'] . "'\" >\n<td>" .
			$row['bID'] . "</td><td class = '" . $statusClass . "' >" . $status['status_name'] .
			"</td><td class = '" . $severityClass . "'>" . $severity['severity_name'] .
			"</td><td>" . $user['real_name'] . "</td><td>" .
			$project['project_name'] .
			"</td><td>" . $private  .
			"</td><td><a href = '" . $SITE_PREFIX . "t/bug/"
				. $row['bID'] . "' >" . $row['title'] .
			"</a></td>\n\t</tr>\n";
		$s++;
	}
}

$CONTENT .= "
</table><br /><br />
";

?>
