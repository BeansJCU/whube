<?php

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

if ( isset( $argv[2] ) ) {
	$class = htmlentities($argv[1], ENT_QUOTES);
	$id    = htmlentities($argv[2], ENT_QUOTES);
}

$TITLE = "Latest $Count projects";

$CONTENT .= "<h1>Last $Count projects created</h1>";

$CONTENT .= "
<table class = 'sortable' >
	<tr class = 'nobg' >
		<th>Name</th> <th>Owner</th> <th>Bugs</th> <th>Private</th>
	</tr>
";

$p = $PROJECT_OBJECT;
$u = $USER_OBJECT;
$b = $BUG_OBJECT;

$p->getAll();
$u->getAll();
$b->getAll();

$s = 0;

$projects = $p->getAllProjects();
$pCount = count($projects);

while ( $s < $pCount ) {
	$row = $projects[$s];
  $p->getAllByPK( $row['pID'] );
  $u->getAllByPK( $row['owner'] );

  $u->getByCol( 'uID', $row['owner'] );
  $user = $u->getNext();
  
  $bugs = $b->numRows();

  $bugCount = 0;
  $i = 0;
  while ( $i < $bugs ) {
    $bug = $b->getNext();   
    if ( $bug['bug_status'] != 8 ) $bugCount++;
    $i++;
  }
  
  
  if ( $row['private'] == 1 ) {
    $private = "Yep";
  } else {
    $private = "No";
  }

	if ( strpos ( $row['project_name'], ' ' ) ) {
		$projectLink = str_replace ( ' ', '-', $row['project_name'] );
	} else {
		$projectLink = $row['project_name'];
	}
	
	$CONTENT .= "\t<tr style=\"cursor:pointer\" onclick=\"document.location.href = '" . $SITE_PREFIX . "t/project/" . $projectLink . "'\" ><td>
	<a href='" . $SITE_PREFIX . "t/project/" . $projectLink . "'>" .  $row['project_name'] . "</a></td><td>" . $user['username'] . "</td><td>" . $bugCount . "</td><td>" . $private . "</td>
  \n\t</tr>\n";
	$s++;
}

$CONTENT .= "
</table><br /><br />
";

?>
