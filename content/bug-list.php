<?php

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

if ( isset( $argv[2] ) ) {
	$class = htmlentities($argv[1], ENT_QUOTES);
	$id    = htmlentities($argv[2], ENT_QUOTES);
	// echo "Getting $id bugs filtering by $class";
}


$b = $BUG_OBJECT;
$b->getAll();

$u = new user();
$p = new project();

$TITLE = "Latest $Count bugs";

$i = 0;

$CONTENT .= "<h1>Last $Count bugs filed</h1>";

$CONTENT .= "
<table class = 'sortable' >
	<tr class = 'nobg' >
		<th>ID</th> <th> Status </th> <th> Severity </th> <th>Owner</th> <th>Project</th> <th>Private</th> <th>Title</th>
	</tr>
";

while ( $row = $b->getNext() ) {

	$u->getAllByPK( $row['owner'] );
	$owner = $u->getNext();

	if ( $owner['uID'] <= 0 ) {
		$owner['real_name'] = "Nobody";
	}

	$p->getAllByPK( $row['package'] );
	$package = $p->getNext();


	if ( isset ( $_SESSION['id'] ) ) {
		$id = $_SESSION['id'];
	} else {
		$id = -1; // NOT -10000!!!!!!
	}

	$privacy = checkBugViewAuth( $row['bID'], $id );

	if ( $privacy[1] ) {
		$picon = "<img src = '" . $SITE_PREFIX . "imgs/locked.png' alt = 'Private' />";
	} else {
		$picon = "<img src = '" . $SITE_PREFIX . "imgs/unlocked.png' alt = 'Public' />";
	}

	if ( ! $privacy[0] ) {

		if ( $i < $Count ) {
			$CONTENT .= "\t<tr>\n<td>" .
				$row['bID'] . "<td>Unknown</td><td>Unknown</td></td><td>Unknown</td><td>Private</td><td>" .
				$picon  . "</td><td>Private</td>\n\t</tr>\n";
		} else {
			break;
		}
	} else {
		if ( $i < $Count ) {
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


			if ( $status['critical'] ) {
				$CONTENT .= "\t<tr onclick=\"document.location.href = '" . $SITE_PREFIX . "t/bug/" . $row['bID'] . "'\" >\n<td>" .
					$row['bID'] . "</td><td class = '" . $statusClass . "' >" . $status['status_name'] .
					"</td><td class = '" . $severityClass . "'>" . $severity['severity_name'] .
					"</td><td>" . $owner['real_name'] . "</td><td>" .
					$package['project_name'] .
					"</td><td>" . $picon  .
					"</td><td><a href = '" . $SITE_PREFIX . "t/bug/"
						. $row['bID'] . "' >" . $row['title'] .
					"</a></td>\n\t</tr>\n";
			}
			$i++;
		} else {
			break;
		}
	}
}

$CONTENT .= "
</table><br /><br />
";

?>
