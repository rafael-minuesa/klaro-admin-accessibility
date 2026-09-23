<?php
/**
 * Uninstall cleanup.
 *
 * Removes the plugin's single option. On multisite the option lives in each
 * site's own table, and WordPress runs this file once, so every site is
 * visited in bounded batches with the original site restored afterwards.
 *
 * @package Klaro_Admin_Accessibility
 */

// Exit if not called by WordPress during uninstall.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( ! is_multisite() ) {
	delete_option( 'klaro_aa_options' );
	return;
}

$klaro_aa_batch  = 100;
$klaro_aa_offset = 0;

do {
	$klaro_aa_site_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => $klaro_aa_batch,
			'offset' => $klaro_aa_offset,
		)
	);

	$klaro_aa_found = count( $klaro_aa_site_ids );

	foreach ( $klaro_aa_site_ids as $klaro_aa_site_id ) {
		switch_to_blog( $klaro_aa_site_id );
		delete_option( 'klaro_aa_options' );
		restore_current_blog();
	}

	$klaro_aa_offset += $klaro_aa_batch;
} while ( $klaro_aa_found === $klaro_aa_batch );
