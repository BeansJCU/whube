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


	function help() {
		global $SHELL;	
		global $VERSION;
		echo "Welcome to $SHELL, version $VERSION.";
		// echo "ಠ_ಠ";
	}

	function syntax_error() { echo "Syntax Error! Type `help` for Help!"; }
	function f_exit()       { echo "there is no escape!";                 }
	function pwd()          { echo $_SESSION['cwd'];                      }

	function whoami() {
		if ( isset ( $_SESSION['username'] ) ) {
			echo $_SESSION['username'];
		} else {
			echo "You're not logged in!";
		}
	}

	$commands = array(
		"help"         => "help",
		"syntax_error" => "syntax_error",
		"exit"         => "f_exit",
		"whoami"       => "whoami",
		"pwd"          => "pwd",
	);


	if ( isset ( $_POST['input'] ) ) {
		$cmd = htmlentities( $_POST['input'], ENT_QUOTES );

		if ( isset ( $commands[$cmd] ) ) {
			$commands[$cmd]();
		} else {
			$commands["syntax_error"]();
		}
	}
?>
