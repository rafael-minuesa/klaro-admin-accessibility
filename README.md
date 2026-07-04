# Klaro Admin Accessibility

**Makes the WordPress admin more accessible for users with disabilities.**

![WordPress Plugin](https://img.shields.io/badge/WordPress-Plugin-blue.svg)
![Version](https://img.shields.io/badge/version-1.0.0-green.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-blue.svg)

Companion plugin to the [Klaro accessibility-first theme](https://wordpress.org/themes/klaro/). The theme covers the front end; this plugin covers the admin area. It styles the WordPress core admin, so it works with any theme.

## Features

- **High contrast admin**, black background with white text throughout the admin, including the menu, toolbar, tables, and forms
- **Large admin text**, 18px base text, larger form fields, 44px minimum button height
- **Enhanced focus indicators** (on by default), 3px `#C2410C` outlines on every focused control, `#FFFF00` when combined with high contrast
- **Reduce motion**, forces animation suppression for users whose OS lacks the setting
- **Simplify admin menu**, hides Tools and Comments for non-administrators and removes secondary dashboard widgets
- **Classic editor toggle**, defers to the Classic Editor plugin when that is active

Settings live under **Settings > Admin Accessibility** (site-wide, `manage_options`).

## For developers

```php
add_filter( 'klaro_aa_enabled_features', function ( $features ) {
    $features['high_contrast'] = true; // force a feature on
    return $features;
} );
```

## Development

```bash
composer install
composer phpcs      # WordPress coding standards
./build-wp-org-zip.sh
```

## Current Version

1.0.0

## License

GPLv2 or later.
