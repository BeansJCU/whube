<?php
$view_root        = dirname(  __FILE__ ) . "/";
include( $view_root . "head.php" );
echo Format( $CONTENT );
include( $view_root . "foot.php" );

?>
