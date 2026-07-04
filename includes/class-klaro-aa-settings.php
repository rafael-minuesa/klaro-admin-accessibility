<?php
/**
 * Settings page and option handling.
 *
 * @package Klaro_Admin_Accessibility
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the settings page under Settings and handles the single
 * klaro_aa_options array via the Settings API.
 */
class Klaro_AA_Settings {

	const OPTION_NAME = 'klaro_aa_options';
	const MENU_SLUG   = 'klaro-admin-accessibility';

	/**
	 * Wire up hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		add_filter( 'plugin_action_links_' . KLARO_AA_PLUGIN_BASENAME, array( __CLASS__, 'add_settings_link' ) );
	}

	/**
	 * The feature keys and their defaults.
	 *
	 * @return array<string,bool>
	 */
	public static function get_defaults() {
		return array(
			'high_contrast'    => false,
			'large_text'       => false,
			'focus_indicators' => true,
			'reduce_motion'    => false,
			'simplify_menu'    => false,
			'classic_editor'   => false,
		);
	}

	/**
	 * Resolved options merged over defaults.
	 *
	 * @return array<string,bool>
	 */
	public static function get_options() {
		$options = get_option( self::OPTION_NAME, array() );
		if ( ! is_array( $options ) ) {
			$options = array();
		}
		$options = array_merge( self::get_defaults(), $options );

		/**
		 * Filters the resolved feature flags before they are applied.
		 *
		 * @param array<string,bool> $options Feature keys mapped to booleans:
		 *                                    high_contrast, large_text, focus_indicators,
		 *                                    reduce_motion, simplify_menu, classic_editor.
		 */
		return apply_filters( 'klaro_aa_enabled_features', $options );
	}

	/**
	 * Register the option with its sanitize callback.
	 */
	public static function register_settings() {
		register_setting(
			'klaro_aa_options_group',
			self::OPTION_NAME,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize_options' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * Whitelist the known keys and cast every value to bool.
	 *
	 * @param mixed $input Raw option value.
	 * @return array<string,bool>
	 */
	public static function sanitize_options( $input ) {
		$clean = array();
		if ( ! is_array( $input ) ) {
			$input = array();
		}
		foreach ( array_keys( self::get_defaults() ) as $key ) {
			$clean[ $key ] = ! empty( $input[ $key ] );
		}
		return $clean;
	}

	/**
	 * Add the page under Settings.
	 */
	public static function add_settings_page() {
		add_options_page(
			__( 'Klaro Admin Accessibility', 'klaro-admin-accessibility' ),
			__( 'Admin Accessibility', 'klaro-admin-accessibility' ),
			'manage_options',
			self::MENU_SLUG,
			array( __CLASS__, 'render_settings_page' )
		);
	}

	/**
	 * Settings shortcut on the plugins-list row.
	 *
	 * @param string[] $links Existing action links.
	 * @return string[]
	 */
	public static function add_settings_link( $links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'options-general.php?page=' . self::MENU_SLUG ) ),
			esc_html__( 'Settings', 'klaro-admin-accessibility' )
		);
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * The field definitions for rendering.
	 *
	 * @return array<string,array{label:string,description:string}>
	 */
	private static function get_fields() {
		return array(
			'high_contrast'    => array(
				'label'       => __( 'High contrast admin', 'klaro-admin-accessibility' ),
				'description' => __( 'Black background with white text throughout the admin area for maximum readability.', 'klaro-admin-accessibility' ),
			),
			'large_text'       => array(
				'label'       => __( 'Large admin text', 'klaro-admin-accessibility' ),
				'description' => __( 'Increases admin text to 18px with larger form fields and 44px minimum button height.', 'klaro-admin-accessibility' ),
			),
			'focus_indicators' => array(
				'label'       => __( 'Enhanced focus indicators', 'klaro-admin-accessibility' ),
				'description' => __( 'Highly visible 3px outlines on every focused link, button, and form field.', 'klaro-admin-accessibility' ),
			),
			'reduce_motion'    => array(
				'label'       => __( 'Reduce motion', 'klaro-admin-accessibility' ),
				'description' => __( 'Suppresses admin animations and transitions. WordPress already honors your operating system\'s reduced-motion preference; this forces it on regardless of that setting.', 'klaro-admin-accessibility' ),
			),
			'simplify_menu'    => array(
				'label'       => __( 'Simplify admin menu', 'klaro-admin-accessibility' ),
				'description' => __( 'Hides the Tools and Comments menus for non-administrator users and removes secondary dashboard widgets, reducing cognitive load.', 'klaro-admin-accessibility' ),
			),
			'classic_editor'   => array(
				'label'       => __( 'Use the classic editor', 'klaro-admin-accessibility' ),
				'description' => __( 'Replaces the block editor with the classic editor, which some assistive technology users find easier to navigate. Ignored when the Classic Editor plugin is active.', 'klaro-admin-accessibility' ),
			),
		);
	}

	/**
	 * Render the settings page.
	 */
	public static function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options = self::get_options();
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<p><?php esc_html_e( 'Site-wide accessibility enhancements for the WordPress admin area. Companion plugin to the Klaro theme; works with any theme.', 'klaro-admin-accessibility' ); ?></p>

			<?php if ( class_exists( 'Classic_Editor' ) ) : ?>
				<div class="notice notice-info">
					<p><?php esc_html_e( 'The Classic Editor plugin is active, so it manages the editor and the classic editor option below has no effect.', 'klaro-admin-accessibility' ); ?></p>
				</div>
			<?php endif; ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'klaro_aa_options_group' ); ?>

				<table class="form-table" role="presentation">
					<?php foreach ( self::get_fields() as $key => $field ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $field['label'] ); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text"><span><?php echo esc_html( $field['label'] ); ?></span></legend>
									<label for="klaro-aa-<?php echo esc_attr( $key ); ?>">
										<input
											type="checkbox"
											id="klaro-aa-<?php echo esc_attr( $key ); ?>"
											name="<?php echo esc_attr( self::OPTION_NAME . '[' . $key . ']' ); ?>"
											value="1"
											<?php checked( ! empty( $options[ $key ] ) ); ?>
										/>
										<?php echo esc_html( $field['label'] ); ?>
									</label>
									<p class="description"><?php echo esc_html( $field['description'] ); ?></p>
								</fieldset>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>

				<?php submit_button(); ?>
			</form>

			<div class="notice notice-info inline">
				<p>
					<strong><?php esc_html_e( 'WordPress built-in accessibility features:', 'klaro-admin-accessibility' ); ?></strong>
					<?php esc_html_e( 'The admin already includes keyboard shortcuts, screen reader landmarks, a "Skip to main content" link, and honors your system\'s reduced-motion preference. This plugin adds options on top of those.', 'klaro-admin-accessibility' ); ?>
				</p>
			</div>
		</div>
		<?php
	}
}
