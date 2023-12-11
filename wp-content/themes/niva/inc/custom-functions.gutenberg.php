<?php
// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 'niva_add_gutenberg_assets' );
/**
 * Load Gutenberg stylesheet.
 */
function niva_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'niva-gutenberg-style', get_theme_file_uri( '/css/gutenberg-editor-style.css' ), false );
    wp_enqueue_style( 
        'niva-gutenberg-fonts', 
        '//fonts.googleapis.com/css?family=Poppins:300,regular,500,600,700,latin-ext,latin,devanagari' 
    ); 
}
?>