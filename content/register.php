<?php
useScript('timezone.js');

if( isset( $_SESSION ) && $_SESSION['rights']['admin'] == 0 ) {
	$_SESSION['err'] = "You are logged in!";
	header( "Location: $SITE_PREFIX" . "t/welcome" );
	exit(0);
}

$TITLE = "Register!";
$CONTENT  = "<h1>So, you want an account, eh?</h1>";

if( isset( $_SESSION ) && $_SESSION['rights']['admin'] == 1 ) {
	$TITLE = "Register a new user!";
	$CONTENT = "<h1>Register a new user</h1>";
}

$CONTENT .= "
<form action = '" . $SITE_PREFIX . "l/submit-register' method = 'post' >
<table>
	<tr>
		<td>Desired Username</td>
		<td></td>
		<td><input type = 'text' name = 'username' id = 'username' /></td>
	</tr>
	<tr>
		<td>Your Real Name ( First and Last, please )</td>
		<td></td>
		<td><input type = 'text' name = 'relaname' id = 'relaname' /></td>
	</tr>
	<tr>
		<td>Email addy</td>
		<td></td>
		<td><input type = 'text' name = 'email' id = 'email' /></td>
	</tr>
	<tr>
		<td>Password ( take one )</td>
		<td></td>
		<td><input type = 'password' name = 'pass0' id = 'pass0' /></td>
	</tr>
	<tr>
		<td>Password ( take two )</td>
		<td></td>
		<td><input type = 'password' name = 'pass1' id = 'pass1' /></td>
	</tr>
	<tr>
		<td><input type = 'hidden' name = 'tz' id = 'tz' /></td>
		<td></td>
		<td><input type = 'submit' name = 'new-user' id = 'submit' value = 'will you remember me?' /></td>
		<td><input type = 'text' name = 'firstname' id = 'firstname' /></td>
	</tr>
</table>
</form>
";

?>
