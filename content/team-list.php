<?php

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

if ( isset( $argv[2] ) ) {
	$class = htmlentities($argv[1], ENT_QUOTES);
	$id    = htmlentities($argv[2], ENT_QUOTES);
}

$TITLE = "Latest $Count teams";

$CONTENT .= "<h1>Last $Count teams created</h1>";

$CONTENT .= "
<table class = 'sortable' >
	<tr class = 'nobg' >
		<th>Name</th> <th>Owner</th> <th>Members</th> <th>Private</th>
	</tr>
";

$t = $TEAM_OBJECT;
$u = $USER_OBJECT;

$t->getAll();
$u->getAll();

$s = 0;

$teams = $t->getAllTeams();
$tCount = count($teams);

while ( $s < $tCount ) {
	$row = $teams[$s];
  $t->getAllByPK( $row['tID'] );
  $u->getAllByPK( $row['owner'] );

  $u->getByCol( 'uID', $row['owner'] );
  $user = $u->getNext();
  $owner = $user;
  $users = $u->numRows();

  $teamCount = 0;
  $i = 0;
  while ( $i < $users ) {
    $user = $u->getNext();   
    if ( $user['team'] == $tID ) $teamCount++;
    $i++;
  }
  
  
  if ( $row['private'] == 1 ) {
    $private = "Yep";
  } else {
    $private = "No";
  }

if ( strpos ( $row['team_name'], ' ' ) ) {
	$teamLink = str_replace ( ' ', '-', $row['team_name'] );
} else {
	$teamLink = $row['team_name'];
}

  $CONTENT .= "\t<tr style=\"cursor:pointer\" onclick=\"document.location.href = '" . $SITE_PREFIX . "t/team/" . $teamLink . "'\" ><td>" .
  $row['team_name'] . "</td><td>" . $owner['username'] . "</td><td>" . $teamCount . "</td><td>" . $private . "</td>
  \n\t</tr>\n";
	$s++;
}

$CONTENT .= "
</table><br /><br />
";

?>
