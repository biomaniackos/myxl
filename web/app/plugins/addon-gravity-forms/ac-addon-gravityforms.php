<?php
/*
Plugin Name: 		Admin Columns - Gravity Forms add-on
Version: 			1.0.2
Description: 		Adds columns to your Gravity Forms submissions
Author: 			Codepress
Author URI: 		https://admincolumns.com
Text Domain: 		codepress-admin-columns
*/

use AC\Autoloader;
use ACA\GravityForms\Dependencies;
use ACA\GravityForms\GravityForms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_admin() ) {
	return;
}

require_once __DIR__ . '/classes/Dependencies.php';

add_action( 'after_setup_theme', function () {
	$dependencies = new Dependencies( plugin_basename( __FILE__ ), '1.0.2' );
	$dependencies->requires_acp( '5.5' );
	$dependencies->requires_php( '5.6.3' );

	if ( ! class_exists( 'GFCommon' ) ) {
		$dependencies->add_missing_plugin( 'Gravity Forms', 'https://www.gravityforms.com/' );
	}

	if ( class_exists( 'GFCommon' ) && GFCommon::$version < '2.5' ) {
		$dependencies->add_missing( sprintf( __( 'the current version of this add-on is not compatible with the current version or settings of %s.', 'codepress-admin-columns' ), 'Gravity Forms' ), 'gravity_forms' );
	}

	if ( $dependencies->has_missing() ) {
		return;
	}

	Autoloader::instance()->register_prefix( 'ACA\GravityForms', __DIR__ . '/classes/' );

	$addon = new GravityForms( __FILE__ );
	$addon->register();
} );