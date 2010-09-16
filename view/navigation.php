<?php
function whubeNav() {
	global $SITE_PREFIX;
	
	$nav = "<div class = 'nav' >";
		if ( isset ( $_SESSION['id'] ) && $_SESSION['id'] > 0) {
			$nav .= "<a href = '" . $SITE_PREFIX . "t/home' >Home</a> | ";
		} else {
			$nav .= "<a href = '" . $SITE_PREFIX . "t/default' >Home</a> | ";
		}
	$nav .= "<a href = '" . $SITE_PREFIX . "t/bug-list' >Bug List</a> | 
		<a href = '" . $SITE_PREFIX . "t/project-list' >Project List</a> | ";
		if ( isset ( $_SESSION['id'] ) && $_SESSION['id'] > 0) {
			$nav .= "<a href = '" . $SITE_PREFIX . "t/new-project' >New Project</a> | 
			<a href = '" . $SITE_PREFIX . "t/new-bug' >New Bug</a> | 
			<a href = '" . $SITE_PREFIX . "t/logout' >Logout</a>
			( You're <span class = 'itsme' >" . $_SESSION['real_name'] . "</span>, Right? )";
		} else {
			$nav .= "<a href = '" . $SITE_PREFIX . "t/register' >Register</a> | 
			<a href = '" . $SITE_PREFIX . "t/login' >Login</a>";
		}
	$nav .= "</div>";
	
	return $nav;
}
?>
