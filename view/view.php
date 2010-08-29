<?php
$view_root        = dirname(  __FILE__ ) . "/";
include( $view_root . "navigation.php" );
include( $view_root . "head.php" );
echo format( $CONTENT );
include( $view_root . "foot.php" );

?>
