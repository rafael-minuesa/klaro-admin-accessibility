<?php
/**
 * Plugin Name: Klaro Admin Accessibility
 * Plugin URI: https://github.com/rafael-minuesa/klaro-admin-accessibility
 * Description: Makes the WordPress admin more accessible: high contrast mode, large text, enhanced focus indicators, reduced motion, a simplified menu, and a classic editor toggle. Companion plugin to the Klaro theme, works with any theme.
 * Version: 1.0.1
 * Author: Rafael Minuesa
 * Author URI: https://prowoos.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: klaro-admin-accessibility
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 7.0
 * Requires PHP: 7.4
 *
 * @package Klaro_Admin_Accessibility
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KLARO_AA_VERSION', '1.0.1' );
define( 'KLARO_AA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'KLARO_AA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'KLARO_AA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once KLARO_AA_PLUGIN_DIR . 'includes/class-klaro-aa-settings.php';
require_once KLARO_AA_PLUGIN_DIR . 'includes/class-klaro-aa-features.php';

Klaro_AA_Settings::init();
Klaro_AA_Features::init();
