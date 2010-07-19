<?php

useScript("sorttable.js");
useScript("tablehover.js");

$Count = $PAGE_MAX_COUNT;

if ( isset( $argv[2] ) ) {
	$class = htmlentities($argv[1], ENT_QUOTES);
	$id    = htmlentities($argv[2], ENT_QUOTES);
}

$TITLE = "Latest $Count projects";

$i = 0;

$CONTENT .= "<h1>Last $Count projects created</h1>";

$CONTENT .= "
<table class = 'sortable' >
	<tr class = 'nobg' >
		<th>Name</th> <th>Owner</th> <th>Bugs</th> <th>Private</th>
	</tr>
";

$p = new project();
$u = new user();
$b = new bug();
$p->getAll();
$u->getAll();
$b->getAll();

while ( $row = $p->getNext() ) {
  $p->getAllByPK( $row['pID'] );
  $u->getAllByPK( $row['uID'] );
  $project = $p->getNext();  
  $b->getByCol( 'package', $project['pID'] );
  $bug = $b->getNext();
  $u->getByCol( 'uID', $project['owner'] );
  $user = $u->getNext();
  
  $bugCount = $b->numRows();
    
  if ( $project['private'] == 1 ) {
    $private = "Yes";
  } else {
    $private = "No";
  }

  $CONTENT .= "\t<tr onclick=\"document.location.href = '" . $SITE_PREFIX . "t/project/" . $project['project_name'] . "'\" ><td>" .
  $project['project_name'] . "</td><td>" . $user['username'] . "</td><td>" . $bugCount . "</td><td>" . $private . "</td>
  \n\t</tr>\n";
	$i++;
}

$CONTENT .= "
</table><br /><br />
";

?>
