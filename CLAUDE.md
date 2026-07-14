# Klaro Admin Accessibility - Development Notes

## Project Overview

WordPress plugin making the admin area accessible: high contrast, large text, focus indicators, reduced motion, simplified menu, classic editor toggle. Companion to the Klaro theme (wordpress.org/themes/klaro) but theme-independent (styles core admin selectors only). Origin: the theme's `inc/admin-accessibility.php`, removed in theme v1.3.7 at reviewer request; legacy copy in `../../000/`.

## Current Version

**v1.0.1** (2026-07-15) - Large text mode fixes: button padding, classic editor status bar text size.

## File Structure

- `klaro-admin-accessibility.php` — header, constants (`KLARO_AA_VERSION` etc.), bootstrap
- `includes/class-klaro-aa-settings.php` — Settings API page (Settings > Admin Accessibility), option `klaro_aa_options`, sanitize whitelist, `klaro_aa_enabled_features` filter
- `includes/class-klaro-aa-features.php` — applies features: body classes + enqueued CSS, menu/dashboard simplification, classic editor filters
- `assets/css/admin.css` — ALL feature CSS, gated by `body.klaro-aa-*` classes
- `uninstall.php` — deletes `klaro_aa_options`

## Naming Conventions

- PHP functions/options: `klaro_aa_*`; constants: `KLARO_AA_*`; classes: `Klaro_AA_*`
- Body classes / HTML ids: `klaro-aa-*`
- Text domain: `klaro-admin-accessibility` (= slug); no `load_plugin_textdomain` needed (wp.org auto-loads since 4.6)
- NEVER use the bare `klaro_` prefix (theme collision)

## Key Implementation Details

- High contrast works as a FORCED-COLORS sweep over `#wpbody-content`: every author background inside the content area is stripped (`background-color: transparent !important` + white text), EXCEPT elements with inline background styles (color swatches/previews survive). Component rules (nav-tabs, buttons, list-table striping, inverted table headers) sit above the sweep with higher-specificity selectors. This is what makes third-party plugin screens readable without per-plugin patches.
- SELECTOR GOTCHA: `.wp-core-ui` is a class ON `<body>`. `body.klaro-aa-high-contrast .wp-core-ui .button` never matches (descendant can't be the body itself); it must be the compound `body.klaro-aa-high-contrast.wp-core-ui .button`. This bug shipped silently in the first port from the legacy theme code.

- Features are CSS-only where possible: `admin_body_class` filter adds `klaro-aa-<feature>` classes, one static stylesheet enqueued only when a visual feature is on. No inline style/script echo anywhere (review requirement).
- Focus indicator: `#C2410C` (5.18:1), switches to `#FFFF00` when combined with high contrast, same pairing as the theme. The legacy `#FF6B00` fails contrast, never revert.
- Classic editor toggle bails out when `class_exists( 'Classic_Editor' )`.
- Settings API handles nonces (`settings_fields('klaro_aa_options_group')`); sanitize callback whitelists the 6 keys and casts to bool.
- `simplify_menu` gates the menu removals (non-admins only), the dashboard meta box removals (legacy removed those unconditionally, a bug), AND a forced one-column dashboard (`screen_layout_columns` + `get_user_option_screen_layout_dashboard` filters); the user's own column choice returns when the option is off.

## Build Process

```bash
composer install && composer phpcs   # WordPress standard, must be clean
./build-wp-org-zip.sh                # zip lands one level up (www/)
```

## Release Checklist

1. Update `Version:` header AND `KLARO_AA_VERSION` in `klaro-admin-accessibility.php` (keep them in sync; APE's drifted)
2. Update `Stable tag:` in `readme.txt` + changelog entry
3. Add entry to `CHANGELOG.md`
4. Update version badge + Current Version in `README.md`
5. Update Current Version in this CLAUDE.md
6. `composer phpcs` clean, Plugin Check clean, test on local WP
7. Build zip; wp.org SVN (plugins use trunk/tags, checkout not yet created)

## Local Development Environment

- WordPress: `/srv/http/wordpress/` (http://localhost/wordpress/), plugin symlink/copy to `wp-content/plugins/klaro-admin-accessibility`
- Test with wp-cli as user `http`: `sudo -u http wp --path=/srv/http/wordpress ...`

## WordPress.org

- Not yet submitted. Rafael submits at https://wordpress.org/plugins/developers/add/ once assets (banner/icon/screenshots in `.wordpress-org/`) are ready.
- After approval: SVN trunk/tags workflow (like advanced-pixel-editor), SVN user `rafael.minuesa`.
