<?php
/**
 * Applies the enabled accessibility features.
 *
 * @package Klaro_Admin_Accessibility
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reads the resolved options and wires each enabled feature into the admin.
 */
class Klaro_AA_Features {

	/**
	 * Feature keys that only need CSS (body class + stylesheet).
	 *
	 * @var string[]
	 */
	private static $css_features = array( 'high_contrast', 'large_text', 'focus_indicators', 'reduce_motion' );

	/**
	 * Wire up hooks.
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		add_filter( 'admin_body_class', array( __CLASS__, 'add_body_classes' ) );
		add_action( 'admin_menu', array( __CLASS__, 'simplify_admin_menu' ), 999 );
		add_action( 'wp_dashboard_setup', array( __CLASS__, 'simplify_dashboard' ), 999 );
		add_action( 'plugins_loaded', array( __CLASS__, 'maybe_use_classic_editor' ) );
	}

	/**
	 * Whether any CSS-driven feature is enabled.
	 *
	 * @return bool
	 */
	private static function has_css_feature() {
		$options = Klaro_AA_Settings::get_options();
		foreach ( self::$css_features as $key ) {
			if ( ! empty( $options[ $key ] ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Enqueue the admin stylesheet only when a visual feature is on.
	 */
	public static function enqueue_styles() {
		if ( ! self::has_css_feature() ) {
			return;
		}
		wp_enqueue_style(
			'klaro-aa-admin',
			KLARO_AA_PLUGIN_URL . 'assets/css/admin.css',
			array(),
			KLARO_AA_VERSION
		);
	}

	/**
	 * Add one body class per enabled visual feature.
	 *
	 * @param string $classes Space-separated admin body classes.
	 * @return string
	 */
	public static function add_body_classes( $classes ) {
		$options = Klaro_AA_Settings::get_options();
		foreach ( self::$css_features as $key ) {
			if ( ! empty( $options[ $key ] ) ) {
				$classes .= ' klaro-aa-' . str_replace( '_', '-', $key );
			}
		}
		return $classes;
	}

	/**
	 * Hide Tools and Comments for non-administrators when enabled.
	 */
	public static function simplify_admin_menu() {
		$options = Klaro_AA_Settings::get_options();
		if ( empty( $options['simplify_menu'] ) ) {
			return;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'edit-comments.php' );
		}
	}

	/**
	 * Remove secondary dashboard widgets when enabled.
	 */
	public static function simplify_dashboard() {
		$options = Klaro_AA_Settings::get_options();
		if ( empty( $options['simplify_menu'] ) ) {
			return;
		}
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	}

	/**
	 * Switch to the classic editor when enabled and the Classic Editor
	 * plugin is not already managing the editor.
	 */
	public static function maybe_use_classic_editor() {
		$options = Klaro_AA_Settings::get_options();
		if ( empty( $options['classic_editor'] ) ) {
			return;
		}
		if ( class_exists( 'Classic_Editor' ) ) {
			return;
		}
		add_filter( 'use_block_editor_for_post', '__return_false' );
		add_filter( 'use_block_editor_for_post_type', '__return_false' );
	}
}
