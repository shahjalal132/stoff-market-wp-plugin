<?php

/*
 * Plugin Name:       Stoff Market
 * Plugin URI:        #
 * Description:       Stoff Market
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shah jalal
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       imjol-contact-form
 * Domain Path:       /languages
 */

// Define plugin path
if ( !defined( 'STOFF_PLUGIN_PATH' ) ) {
    define( 'STOFF_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Define plugin url
if ( !defined( 'STOFF_PLUGIN_URI' ) ) {
    define( 'STOFF_PLUGIN_URI', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
}

// require files
require_once STOFF_PLUGIN_PATH . '/inc/Enqueue_Assets.php';
require_once STOFF_PLUGIN_PATH . '/inc/Form_Shortcode.php';
require_once STOFF_PLUGIN_PATH . '/inc/Rest_API.php';