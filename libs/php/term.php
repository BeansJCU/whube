<?php

	session_start();

	if ( ! isset ( $_SESSION['id'] ) ) {
		$_SESSION['id'] = -1;
	}

	$app_root        = dirname(  __FILE__ ) . "/../../";

	include( $app_root . "conf/site.php" );
	include( $app_root . "libs/php/globals.php" );
	include( $app_root . "libs/php/easter.php" );
	include( $app_root . "libs/php/core.php" );

	if ($handle = opendir( $app_root . "model/" )) {
		while (false !== ($file = readdir($handle))) {
			// The "i" after the pattern delimiter indicates a case-insensitive search
			if ( $file != "." && $file != ".." ) {
				$ftest = $file;
				if (preg_match("/.*\.php$/i", $ftest)) {
					include( $app_root . "model/" . $file );
				}
			}
		}
	}

	$SHELL = "WHUBIX";

	$commands = array(
		"help"         => "Welcome to $SHELL, version $VERSION.\nHelp menu is forthcoming.",
		"syntax_error" => "Syntax Error! Type `help` for Help!",
		"exit"         => "There is no escape!",

	);


	if ( isset ( $_POST['input'] ) ) {
		$cmd = htmlentities( $_POST['input'], ENT_QUOTES );

		if ( isset ( $commands[$cmd] ) ) {
			echo $commands[$cmd];
		} else {
			echo $commands["syntax_error"];
		}
	}
?>
