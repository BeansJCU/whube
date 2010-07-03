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

	requireLogin();

	if ( ! isset ( $_SESSION['cwd'] ) ) {
		$_SESSION['cwd'] = "/";
	}

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

	$commands = array();

	if ($handle = opendir( dirname(__FILE__) . "/" . "term-commands/" )) {
		while (false !== ($file = readdir($handle))) {
			// The "i" after the pattern delimiter indicates a case-insensitive search
			if ( $file != "." && $file != ".." ) {
				$ftest = $file;
				if (preg_match("/.*\.php$/i", $ftest)) {
					include( dirname(__FILE__) . "/" . "term-commands/" . $file );
				}
			}
		}
	}


	if ( isset ( $_POST['input'] ) ) {
		$cmd = htmlentities( $_POST['input'], ENT_QUOTES );

		$toks = explode( " ", $_POST['input'] );

		$argv = $toks;
		$argc = sizeof( $toks );

		if ( isset ( $commands[$argv[0]] ) ) {
			$commands[$argv[0]]( $argv );
		} else {
			$commands["syntax_error"]( $argv );
		}
	}
?>
