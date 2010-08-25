<?php
	/*
	 * Miscellaneous Formatting Functions
	 */

function Format( $text ) {
		$text = str_replace( '&amp;', '&', $text );
		return $text;
}

?>
