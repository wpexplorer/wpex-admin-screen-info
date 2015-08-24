<?php
/**
 * Plugin Name: WPEX Admin Screen Info
 *
 * Plugin based on the tutorial found here: http://code.tutsplus.com/articles/quick-tip-get-the-current-screens-hooks--wp-26891
 *
 * Author: AJ Clarke
 * Author URI: http://www.wpexplorer.com
 * Version: 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wpex_help_tab_screen_info( $contextual_help, $screen_id, $screen ) {
 
	// Get global hook suffix
	global $hook_suffix;
 
	// List screen properties
	$variables = '<ul style="width:50%;float:left;"> <strong>Screen variables </strong>'
		. sprintf( '<li> Screen id : %s</li>', $screen_id )
		. sprintf( '<li> Screen base : %s</li>', $screen->base )
		. sprintf( '<li>Parent base : %s</li>', $screen->parent_base )
		. sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
		. sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
		. '</ul>';
 
	// Append global $hook_suffix to the hook stems
	$hooks = array(
		"load-$hook_suffix",
		"admin_print_styles-$hook_suffix",
		"admin_print_scripts-$hook_suffix",
		"admin_head-$hook_suffix",
		"admin_footer-$hook_suffix"
	);
 
	// If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
	if ( did_action( 'add_meta_boxes_' . $screen_id ) ) {
		$hooks[] = 'add_meta_boxes_' . $screen_id;
	}
 
	if ( did_action( 'add_meta_boxes' ) ) {
		$hooks[] = 'add_meta_boxes';
	}
 
	// Get List HTML for the hooks
	$hooks = '<ul style="width:50%;float:left;"> <strong>'. __( 'Hooks', 'wpex' ) .' </strong> <li>' . implode( '</li><li>', $hooks ) . '</li></ul>';
 
	// Combine $variables list with $hooks list.
	$help_content = $variables . $hooks;
 
	// Add help panel
	$screen->add_help_tab( array(
		'id'      => 'wpex-screen-info',
		'title'   => __( 'Screen Information', 'wpex' ),
		'content' => $help_content,
	) );
 	
 	// Return contextual help content
	return $contextual_help;

}
add_action( 'contextual_help', 'wpex_help_tab_screen_info', 40, 3 );