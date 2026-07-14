# Changelog

All notable changes to the Klaro Admin Accessibility plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
