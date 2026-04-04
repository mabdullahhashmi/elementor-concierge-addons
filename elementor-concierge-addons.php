<?php
/**
 * Plugin Name: Elementor Concierge Addons
 * Description: Custom Elementor widgets for Concierge Golf Scotland tour pages.
 * Version: 1.0.0
 * Author: Concierge Golf Scotland
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elementor-concierge-addons
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'ELEMENTOR_CONCIERGE_ADDONS_VERSION', '1.0.0' );
define( 'ELEMENTOR_CONCIERGE_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELEMENTOR_CONCIERGE_ADDONS_URL', plugin_dir_url( __FILE__ ) );

// Include the main plugin class
require_once ELEMENTOR_CONCIERGE_ADDONS_PATH . 'includes/class-elementor-addons.php';

/**
 * Run the plugin
 */
function elementor_concierge_addons_run() {
	Elementor_Concierge_Addons::instance();
}

// Initialize on plugins_loaded
add_action( 'plugins_loaded', 'elementor_concierge_addons_run' );
