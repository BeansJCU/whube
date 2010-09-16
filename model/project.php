<?php
/**
 * project class file, All project model work lies herein
 * 
 * Base project class to do bug CRUD work.
 * @author   Paul Tagliamonte <paultag@whube.com>
 * @version  1.0
 * @license: AGPLv3
 */

if ( ! class_exists ( "project" ) ) {

if ( ! class_exists( "dbobj" ) ) {
        // last ditch...
        $model_root = dirname(  __FILE__ ) . "/";
        include( $model_root . "dbobj.php" );
}

class project extends dbobj {
	function project() {
		dbobj::dbobj("projects", "pID");
	}

	function hasRights( $user, $project ) {
		global $TABLE_PREFIX;
		$sql = new sql();
		$sql->query("SELECT * FROM " . $TABLE_PREFIX . "project_members WHERE projectID = \"$project\" AND userID = \"$user\";" );

		$row = $sql->getNextRow();

		if ( $row != NULL || $row['active'] == False ) {
			return false;
		} else {
			return $row['active'];
		}
	}

	function getAllProjects() {
		global $TABLE_PREFIX;
		$sql = new sql();
		$sql->query("SELECT * FROM " . $TABLE_PREFIX . "projects;" );
		$ret = array();
		while ( $row = $sql->getNextRow() ) {
			array_push( $ret, $row );
		}
		return $ret;
	}
}
}


$PROJECT_OBJECT = new project();

?>
