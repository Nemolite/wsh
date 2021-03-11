<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/**
 * Adding a file to modification the child-theme 
 */
require 'include/modification-functions.php';
?>



