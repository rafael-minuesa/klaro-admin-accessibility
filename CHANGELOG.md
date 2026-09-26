# Changelog

All notable changes to the Klaro Admin Accessibility plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed
- Large text: dropdowns in list tables (Products filters, Bulk actions) kept a fixed 32px height and cut their text off. Their height now follows the content (44px).
- High contrast: script-built dropdowns (WooCommerce select controls, block editor comboboxes) had a transparent list panel over the page and dark options on black. Every listbox now has an opaque black panel, white options, and an inverted highlighted or selected option; their value fields (`input[role="combobox"]`) and placeholders are readable too.
- High contrast: WooCommerce stock labels on the Products list read at about 3:1; "In stock", "Out of stock" and "On backorder" now use light green, red and orange at 7:1 or more.

## [1.1.2] - 2026-09-23

### Fixed
- High contrast: the plugin information page (the details modal) is rendered through `iframe_header()` with no `#wpbody-content`, so its white description panel, light sidebar, tabs and footer kept core's backgrounds under the forced white text. The page now gets the black palette: description 21:1, tabs 21:1, sidebar links 11.86:1, footer 21:1.

## [1.1.1] - 2026-09-23

Four fixes from local testing of 1.1.0.

### Fixed
- Large text: the 10px padding on every admin menu link stacked on core's label padding and wrapped "WooCommerce" onto three lines; the size now sits on the label and submenu links only.
- High contrast: WooCommerce's "Store coming soon" admin bar badge, and any admin bar item with an inline background, are black text on white instead of white on light gray (1.07:1).
- High contrast: the Appearance > Themes details overlay had its panels stripped by the content sweep; backdrop, panels and header buttons are black with white text and a white frame.
- High contrast: the readable-pairs rule now covers the bare `button` element, so Site Health's accordion rows read 12.82:1 instead of white on white.

## [1.1.0] - 2026-09-23

Fixes from the September 2026 review, tracked in https://github.com/rafael-minuesa/klaro-admin-accessibility/issues/18. Every change was measured on a live WordPress 7.1.2 admin before merging.

### Fixed
- High contrast: the native focused "Skip to main content" link and the active admin-menu Dashicon were white on white (1:1); both are 21:1 now, including the collapsed menu (#4, #5).
- Dropdowns: high contrast removed the arrow and large text covered its space; a white arrow is restored and 32px is reserved at the inline end, LTR and RTL, native arrow under OS forced colors (#2, #3).
- High contrast sweep: text inside `.button`, `.button-primary`, `.button-secondary`, `.button-link`, `.nav-tab` and `.page-title-action` follows the control's colors; text and links inside an element with a preserved inline background follow that element's color (#6).
- High contrast: the Add Media, attachment details and edit-image dialogs, which live outside the content sweep, get the black palette on their chrome, menus, toolbars and sidebar; attachment tiles keep their light surface and previews (#7).
- High contrast: notice text on admin pages rendered through `iframe_header()` (plugin information) was dark on the black notice; the notice's own text elements are white now (#19).
- High contrast editor: elements with an inline background, and their descendants, keep their background and get black text unless the author set a color; highlighted text went from 1.07:1 to 19.56:1 and a white cell from 1:1 to 21:1 (#10).
- High contrast: the TinyMCE `content_style` filter returns the configuration untouched outside admin requests (#9).
- Large text: paragraphs, list items, labels, legends, descriptions, form-table cells and notice text are 18px; row titles, the Add New action and postbox headings 16px; table rows and buttons keep 16px (#8).
- Settings: each checkbox references its description with `aria-describedby` (#13).
- Classic editor: the preference is resolved inside `use_block_editor_for_post` and `use_block_editor_for_post_type` instead of on `plugins_loaded`, so a theme's `klaro_aa_enabled_features` filter is honored in both directions; the Classic Editor plugin keeps precedence (#12).
- Uninstall: on multisite the option is deleted from every site in batches of 100 (#11).

## [1.0.1] - 2026-07-15

### Fixed
- Large text mode: reduced oversized admin button padding (now 3px 14px, was 10px 18px); the 44px minimum touch-target height is preserved
- Large text mode: the classic editor status bar under the content box (word count, autosave message, last-edited date) is now enlarged to 16px instead of staying at core's 12px

## [1.0.0] - 2026-07-04

Initial release. Rebirth of the admin accessibility subsystem removed from the Klaro theme in v1.3.7 (settings pages are plugin territory per wordpress.org theme review), rebuilt to current plugin review standards.

### Added
- High contrast admin mode (black/white palette, #00D4FF links)
- Large admin text (18px base, 44px minimum button height)
- Enhanced focus indicators, enabled by default (3px #C2410C outline, #FFFF00 on high contrast)
- Reduce motion option (forces animation suppression regardless of OS preference)
- Simplify admin menu option (hides Tools/Comments for non-admins, removes secondary dashboard widgets, switches the dashboard to a single column)
- Classic editor toggle (defers to the Classic Editor plugin when active)
- Settings page under Settings > Admin Accessibility using the Settings API
- `klaro_aa_enabled_features` filter over the resolved feature flags
- `uninstall.php` cleanup of the single `klaro_aa_options` option

### Changed from the legacy theme version
- Focus indicator color #FF6B00 (2.86:1, failed contrast) replaced with #C2410C (5.18:1)
- Inline style/script echoes replaced with one enqueued stylesheet gated by body classes
- Manual $_POST handling replaced with the Settings API (automatic nonces, sanitize callback)
- Settings moved from Appearance to Settings (the Appearance placement caused the theme review rejection)

### Removed from the legacy theme version
- Screen reader JS (skip link, ARIA landmarks, aria-current) that WordPress core now provides natively
- Ungated dashboard widget, admin bar node, and help tab
- Site-wide "Classic Editor is enabled" admin notice
