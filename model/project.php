<?php
    /*
     *  License:     AGPLv3
     *  Author:      Paul Tagliamonte <paultag@ubuntu.com>
     *  Description:
     *    project class
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
