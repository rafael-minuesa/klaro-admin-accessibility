#!/bin/bash
# Build the wordpress.org distribution zip one level up from the plugin dir.
set -e
cd "$(dirname "$0")/.."
rm -f klaro-admin-accessibility.zip
zip -r klaro-admin-accessibility.zip klaro-admin-accessibility \
  -x "klaro-admin-accessibility/.git/*" \
  -x "klaro-admin-accessibility/.gitignore" \
  -x "klaro-admin-accessibility/.claude/*" \
  -x "klaro-admin-accessibility/CLAUDE.md" \
  -x "klaro-admin-accessibility/README.md" \
  -x "klaro-admin-accessibility/CHANGELOG.md" \
  -x "klaro-admin-accessibility/.wordpress-org/*" \
  -x "klaro-admin-accessibility/build-wp-org-zip.sh" \
  -x "klaro-admin-accessibility/composer.json" \
  -x "klaro-admin-accessibility/composer.lock" \
  -x "klaro-admin-accessibility/vendor/*" \
  -x "klaro-admin-accessibility/*.code-workspace"
echo "Built $(pwd)/klaro-admin-accessibility.zip"
echo "Next: test the zip on a clean install, run Plugin Check, then submit at https://wordpress.org/plugins/developers/add/"
