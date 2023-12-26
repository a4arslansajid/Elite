<?php
/*
  Plugin Name: WordPress automation by GURU App Installer
  Description: Management of this WordPress site is provided by GURU App Installer.
*/

// This plugin was added because Automatic Updates, Automatic Backups, and
// other features are managed externally by GURU App Installer.

// To block this plugin, create an empty file in the same directory named:
//     block-automation-by-guruinstaller.php

// Turn off WordPress automatic updates since these are managed externally.
// If you remove this to re-enable WordPress's automatic updates then it's 
// advised to disable auto-updating in GURU App Installer.
add_filter( 'automatic_updater_disabled', '__return_true', -9999 );

// Disable WordPress site health test for Automatic Updates since these are
// managed externally by GURU App Installer.
function guruinstaller_filter_site_status_tests($tests) {
	unset($tests['async']['background_updates']);
	return $tests;
}
add_filter('site_status_tests', 'guruinstaller_filter_site_status_tests');

