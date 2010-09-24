<?php

requireLogin();

if ( isset( $argv[1] ) ) {

$BUG_OBJECT->getAllByPK( $argv[1] );
$bugnug = $BUG_OBJECT->getNext();

$TITLE = "Got something to say?";
$CONTENT .= "
	<h1>Bug description:</h1>
	" . Markdown($bugnug['descr']) . "
	<h1>Speak your mind, kid.</h1>
	<br />
	<br />
	<form action = '" . $SITE_PREFIX . "l/submit-comment' method = 'post' >
		<input type = 'hidden' name = 'bug' value = '" . $bugnug['bID'] . "' />
		<table>
			<tr>
				<td>So, what's on your mind?</td>
				<td></td>
				<td><textarea rows = '20' cols = '50' name = 'descr' ></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><img src = '" . $SITE_PREFIX . "imgs/32_space.png' alt = '' /></td>
				<td><input type = 'submit' value = 'ROCK HARDCORE!' /></td>
			</tr>
		</table>
	</form>
";

} else {
	$_SESSION['err'] = "You need a bug to comment on, silly.";
	header("Location: " . $SITE_PREFIX . "t/bug-list" );
	exit(0);
}

?>
