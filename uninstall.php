<?php
/**
 * Uninstall cleanup.
 *
 * @package Klaro_Admin_Accessibility
 */

// Exit if not called by WordPress during uninstall.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'klaro_aa_options' );
