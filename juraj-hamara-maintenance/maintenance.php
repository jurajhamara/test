<?php
/*
Plugin Name: Maintenance mode by Juraj Hamara
Plugin URI: https://jurajhamara.sk
Description: A lightweight Maintenance Mode plugin
Version: 1.0
Author: Juraj Hamara
Author URI: https://jurajhamara.sk
Text Domain: juraj-hamara-maintenance
*/

function jh_maintenance_mode() {
	if ( ! current_user_can( 'delete_published_posts' ) || ! is_user_logged_in() ) {
		wp_die( '<h1>Na stránke práve prebieha údržba.</h1><br>Vráťte sa prosím neskôr.' );
	}
}
add_action( 'get_header', 'jh_maintenance_mode' );

/* ENQUEUE INLINE SCRIPTS */

function jh_include_inline_style() {
	wp_register_style( 'maintenance-mode-style', false );
	wp_enqueue_style( 'maintenance-mode-style' );

	wp_add_inline_style( 'maintenance-mode-style', '.maintenance-mode, #wpadminbar:not(.mobile) .ab-top-menu>li.maintenance-mode:hover>.ab-item, #wpadminbar:not(.mobile) .ab-top-menu>li.maintenance-mode>.ab-item:focus { background: #eb3a34 !important; color: #f0f0f1 !important; }' );
}
add_action( 'admin_enqueue_scripts', 'jh_include_inline_style', 100 );
add_action( 'wp_enqueue_scripts', 'jh_include_inline_style', 100 );

/* DISPLAY NOTICE */

function jh_notice_toolbar( $wp_admin_bar ) {
	$args = array(
		'id'    => 'maintenance-mode',
		'title' => 'Prebieha údržba',
		'href'  => '',
		'meta'  => array( 'class' => 'maintenance-mode' ),
	);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'jh_notice_toolbar', 9999 );