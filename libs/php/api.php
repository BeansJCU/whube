<?php
    /*
     *  License:     AGPLv3
     *  Author:      Paul Tagliamonte <paultag@whube.com>
     *  Description:
     *    AJAX callbacks for getting internal data
     */

session_start();

$app_root = dirname(  __FILE__ ) . "/../../";

include( $app_root . "conf/site.php" );
include( $app_root . "libs/php/globals.php" );
include( $app_root . "model/user.php" );

requireLocalIP();

$s = new sql();

$d['errors'] = true;
$d['success'] = false;
$d['message'] = "Unknown error";

echo json_encode( $d );

?>
