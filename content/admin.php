<?php

include( "model/user.php" );
include( "libs/php/core.php" );

requireLogin();

$adminMenu = "<table>
	<tr class = 'center'>
		<td><h2>User Administration</h2></td>
		<td><h2>Project Administration</h2></td>
		<td><h2>Team Administration</h2></td>
	</tr>
	<tr class = 'center'>
		<td>
			<a href = '" . $SITE_PREFIX . "t/admin/user/create'>Create</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/user/read'>Read</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/user/update'>Update</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/user/delete'>Delete</a>
		</td>
		<td>
			<a href = '" . $SITE_PREFIX . "t/admin/project/create'>Create</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/project/read'>Read</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/project/update'>Update</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/project/delete'>Delete</a>
		</td>
		<td>
			<a href = '" . $SITE_PREFIX . "t/admin/team/create'>Create</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/team/read'>Read</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/team/update'>Update</a> | 
			<a href = '" . $SITE_PREFIX . "t/admin/team/delete'>Delete</a>
		</td>
	</tr>
</table>";

if( sizeof($argv) > 2 ) {
	$TITLE = ucwords( $argv[2] . " " .$argv[1] );
	$CONTENT = $adminMenu;
	$CONTENT .= "<br /><h1>" . $TITLE . "</h1><br />\n";
	
	if( isset( $argv[3] ) ) {
		if( $argv[2] == "create" ) {
			$_SESSION['err'] = "You shouldn't specify a name in a URL when creating.";
			header("Location: " . $SITE_PREFIX . "t/admin/" . $argv[1] . "/create" );
			exit(0);
		}
		$TITLE .= " " . ucwords( $argv[3] );
	}
} else {
	$TITLE    = "Time to do the dirty!";

	$CONTENT  = "<br /><h1>Heyya, " . $_SESSION['real_name'] . "</h1>Here's your administration page. " . $TITLE . "<br />\n";
	$CONTENT .= $adminMenu;
}

?>
