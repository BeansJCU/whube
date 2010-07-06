<?php
    /*
     *  License:     AGPLv3
     *  Author:      Paul Tagliamonte <paultag@whube.com>
     *  Description:
     *    Default "Hello, World" page
     */

session_start();
include ( "conf/site.php" );
include ( "libs/php/core.php" );
include ( "libs/php/globals.php" );

$TITLE   = "Welcome!";
$CONTENT = $ABOUT_WHUBE;

include( "view/view.php" );

?>
