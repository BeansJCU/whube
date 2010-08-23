<?php
/**
 * team class file, All project model work lies herein
 * 
 * Base team class to do team CRUD work.
 * @author   Paul Tagliamonte <paultag@whube.com>
 * @version  1.0
 * @license: AGPLv3
 */

if ( ! class_exists ( "team" ) ) {

if ( ! class_exists( "dbobj" ) ) {
        // last ditch...
        $model_root = dirname(  __FILE__ ) . "/";
        include( $model_root . "dbobj.php" );
}

class team extends dbobj {
	function team() {
		dbobj::dbobj("teams", "tID");
	}
	
	function getAllTeams() {
		global $TABLE_PREFIX;
		$sql = new sql();
		$sql->query("SELECT * FROM " . $TABLE_PREFIX . "teams;" );
		$ret = array();
		while ( $row = $sql->getNextRow() ) {
			array_push( $ret, $row );
		}
		return $ret;
	}
}
}


$TEAM_OBJECT = new team();

?>
