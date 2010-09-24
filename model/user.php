<?php
/**
 * User class stuff, all the user class model stuff.
 * 
 * User class to do CRUD work.
 * @author   Paul Tagliamonte <paultag@whube.com>
 * @version  1.0
 * @license: AGPLv3
 */
if ( ! class_exists ( "user" ) ) {

if ( ! class_exists( "dbobj" ) ) {
        // last ditch...
        $model_root = dirname(  __FILE__ ) . "/";
        include( $model_root . "dbobj.php" );
}

class user extends dbobj {
	function user() {
		dbobj::dbobj("users", "uID");
	}

	function getAllUsers() {
		global $TABLE_PREFIX;
		$sql = new sql();
		$sql->query("SELECT * FROM " . $TABLE_PREFIX . "users;" );
		$ret = array();
		while ( $row = $sql->getNextRow() ) {
			array_push( $ret, $row );
		}
		return $ret;
	}
	
	function validate_email( $email ) {
	$isValid = true;
	$atIndex = strrpos( $email, "@" );

	if ( is_bool( $atIndex ) && !$atIndex ) {
			$isValid = false;
	} else {
			$domain = substr( $email, $atIndex+1 );
			$local = substr( $email, 0, $atIndex );
			$localLen = strlen( $local );
			$domainLen = strlen( $domain );
			if( $localLen < 1 || $localLen > 64 ) {
				 $isValid = false;
			} else if( $domainLen < 1 || $domainLen > 255 ) {
				 $isValid = false;
			} else if( $local[0] == '.' || $local[$localLen-1] == '.' ) {
				 $isValid = false;
			} else if( preg_match('/\\.\\./', $local ) ) {
				 $isValid = false;
			} else if( !preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain ) ) {
				 $isValid = false;
			} else if( preg_match('/\\.\\./', $domain ) ) {
				 $isValid = false;
			} else if( !preg_match( '/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace( "\\\\","",$local ) ) ) {
				 if ( !preg_match('/^"(\\\\"|[^"])+"$/', str_replace( "\\\\","",$local ) ) ) {
						$isValid = false;
				 }
			}

			if ($isValid && !( checkdnsrr( $domain,"MX" ) || checkdnsrr( $domain,"A" ) ) ) {
				 $isValid = false;
			}
	 }
	return $isValid;
	}

	function teamMembership( $id ) {
		global $TABLE_PREFIX;
		$sql = new sql();
		$sql->query("SELECT * FROM " . $TABLE_PREFIX . "project_members WHERE userID = " . $id . ";" );
		$ret = array();
		while ( $row = $sql->getNextRow() ) {
			array_push( $ret, $row );
		}
		return $ret;
	}
	
	function validate_password( $password, $min, $max ) {
		$password = trim( $password );
		$bad = eregi_replace( '( [a-zA-Z0-9_]{' . $min_char . ',' . $max_char . '} )', '', $password );
		
		if( empty( $bad ) ) {
			$isValid = TRUE;
		} else {
			$isValid = FALSE;
		}
		return $isValid;
	}
}
}

$USER_OBJECT = new user();

?>
