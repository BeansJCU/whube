<?php

include( "model/user.php" );
include( "libs/php/core.php" );

// !include("tablehover.js"); - Will make things look funny.

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

$users = $USER_OBJECT->getAllUsers();

if( sizeof($argv) > 1 ) {
	$TITLE = ucwords( $argv[1] . " " .$argv[2] );
	$CONTENT = $adminMenu;
	$CONTENT .= "<br /><h1>" . $TITLE . "</h1><br />\n";
	if( isset( $argv[3] ) ) {
		if( $argv[1] == "read" ) {
			if( $argv[2] == "user" ) {
				$USER_OBJECT->getByCol("username", $argv[3]);
				$user = $USER_OBJECT->getNext();
				$TITLE .= " " . ucwords( $user["username"] );	
				$CONTENT = $adminMenu;
				$CONTENT .= "<h1>" . $TITLE . "</h1>";
				
				if( $user['private'] == 0 ) $private = "No";
				if( $user['private'] == 1 ) $private = "Yes";
				
				// Getting exposed like a naked monkey
				// and tabled like a bad hand of cards
				$CONTENT .= "User ID: " . $user['uID'] ."<br />
				Real Name: " . $user['real_name'] ."<br />
				Username: " . $user['username'] ."<br />
				Email: " . $user['email'] ."<br /> 
				Locale: " . $user['locale'] ."<br />
				Timezone: " . $user['timezone'] ."<br />
				Private: " . $private ."<br />
				Password: " . $user['password'] ."<br />";
			}
		}
		if( $argv[2] == "create" ) {
			$_SESSION['err'] = "You shouldn't specify a name in a URL when creating.";
			header("Location: " . $SITE_PREFIX . "t/admin/" . $argv[1] . "/create" );
			exit(0);
		}	
	}	else if( !isset( $argv[3] ) && $argv[2] == "read" ) {
		$numUsers = count( $users );
		$i = 0;
		$userList = '';

		while( $i < $numUsers ) {
			$userList .= "<tr style = 'cursor:pointer' onclick=\"document.location.href = '" . $SITE_PREFIX . "t/admin/read/user/" . $users[$i]['username'] . "'\">
											<td>" . $users[$i]['uID'] ."</td> <td><a href = '" . $SITE_PREFIX . "t/admin/read/user/" . $users[$i]['username'] . "'>" . $users[$i]['real_name'] ."</a></td> <td>" . $users[$i]['username'] ."</td> <td>" . $users[$i]['email'] ."</td> 
										</tr>";
			$i++;
		}
		$CONTENT .= "<table class = 'sortable' >";
		$CONTENT .= $userList;
		$CONTENT .="</table>";
	}
} else {
	$TITLE    = "Time to do the dirty!";

	$CONTENT  = "<br /><h1>Heyya, " . $_SESSION['real_name'] . "</h1>Here's your administration page. " . $TITLE . "<br />\n";
	$CONTENT .= $adminMenu;
}

?>
