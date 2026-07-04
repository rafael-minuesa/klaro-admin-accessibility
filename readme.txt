=== Klaro Admin Accessibility ===

Contributors: rafaelminuesa
Tags: accessibility, admin, high contrast, large text, classic editor
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Makes the WordPress admin more accessible: high contrast mode, large text, enhanced focus indicators, reduced motion, and a classic editor toggle.

== Description ==

Klaro Admin Accessibility helps users with visual, motor, or cognitive disabilities work in the WordPress admin area. It is the companion plugin to the [Klaro accessibility-first theme](https://wordpress.org/themes/klaro/), but it targets the WordPress core admin and works with any theme.

= Features =

* **High contrast admin** - Black background with white text throughout the admin area, including the admin menu, toolbar, tables, and forms.
* **Large admin text** - 18px base text, larger form fields, and 44px minimum button height for easier reading and clicking.
* **Enhanced focus indicators** - Highly visible 3px outlines on every focused link, button, and form field, meeting the 3:1 contrast requirement for UI controls.
* **Reduce motion** - Suppresses admin animations and transitions for users whose operating system does not expose a reduced-motion preference.
* **Simplify admin menu** - Hides the Tools and Comments menus for non-administrator users, removes secondary dashboard widgets, and switches the dashboard to a single column, reducing cognitive load.
* **Classic editor toggle** - Replaces the block editor with the classic editor, which some assistive technology users find easier to navigate. Defers to the Classic Editor plugin when that is active.

All settings are site-wide and live under Settings > Admin Accessibility.

= What WordPress already provides =

The WordPress admin already ships keyboard shortcuts, screen reader landmarks, a "Skip to main content" link, and honors your operating system's reduced-motion preference. This plugin adds options on top of those built-in features instead of duplicating them.

= For developers =

The resolved feature flags can be filtered:

`add_filter( 'klaro_aa_enabled_features', function ( $features ) {
    $features['high_contrast'] = true; // force a feature on
    return $features;
} );`

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/klaro-admin-accessibility/`, or install through the WordPress plugins screen.
2. Activate the plugin.
3. Go to Settings > Admin Accessibility to enable the features you need.

== Frequently Asked Questions ==

= Does this affect my site's visitors? =

No. Every feature applies to the admin area only. Front-end accessibility is the theme's job (the Klaro theme covers it).

= Do I need the Klaro theme? =

No. The plugin styles the WordPress core admin and works with any theme.

= Are the settings per-user? =

Version 1.0.0 applies settings site-wide. Per-user preferences are planned for a future release.

= What happens on uninstall? =

The plugin deletes its single `klaro_aa_options` option. No other data is stored.

== Screenshots ==

1. The settings page under Settings > Admin Accessibility.
2. High contrast admin mode.
3. Large admin text with enhanced focus indicators.

== Changelog ==

= 1.0.0 =
* Initial release
* High contrast admin mode
* Large admin text
* Enhanced focus indicators (enabled by default)
* Reduce motion option
* Simplified admin menu option (single-column dashboard, fewer widgets and menus)
* Classic editor toggle

== Upgrade Notice ==

= 1.0.0 =
Initial release.
