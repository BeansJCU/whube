<?php
	function help( $argv ) {
		global $SHELL;	
		global $VERSION;
		// echo "Welcome to $SHELL, version $VERSION.";
		echo "ಠ_ಠ";
	}
	$commands['help'] = "help";

	function syntax_error( $argv ) {
		echo "Syntax Error! No such command `" .
			$argv[0] .
			"`!\n&nbsp;Type `help` for Help!";
	}
	$commands['syntax_error'] = "syntax_error";

	function f_exit( $argv )       { echo "there is no escape!"; }
	$commands['exit'] = "f_exit";

	function pwd( $argv )          { echo $_SESSION['cwd']; }
	$commands['pwd'] = "pwd";

	function version( $argv ){
		global $SHELL;
		global $VERSION;
		echo "$SHELL/$VERSION";
	}
	$commands['version'] = "version";

	function whoami( $argv ) {
		if ( isset ( $_SESSION['username'] ) ) {
			echo $_SESSION['username'];
		} else {
			echo "You're not logged in!";
		}
	}
	$commands['whoami'] = "whoami";
?>
