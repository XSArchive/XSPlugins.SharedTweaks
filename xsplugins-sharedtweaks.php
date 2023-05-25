<?php
/*
Plugin Name: XerShade's Plugins - Shared Tweaks
Plugin URI: https://github.com/XerShade/XSPlugins.SharedTweaks
Description: A wordpress plugin that contains commonly used website specific code tweaks.
Author: XerShade
Author URI: https://www.xershade.ca/
Version: 1.0.0
*/

/**
* This hides the login and password fields so only the social login buttons are visible.
* This styles the social login buttons, because I'm not paying $70 for a plugin that does it.
*/
add_action( 'login_enqueue_scripts', 'enqueue_login_tweaks', 100 );
if ( ! function_exists( 'enqueue_login_tweaks' ) ) {
    function enqueue_login_tweaks() {
        wp_enqueue_style( 'wordpress.login.tweaks', plugins_url( 'css/wordpress.login.tweaks.css' , __FILE__ ) );
        wp_enqueue_style( 'social.login.tweaks', plugins_url( 'css/social.login.tweaks.css' , __FILE__ ) );
    }
}

/**
* This replaces words in the administartor panels and other wordpress components we can't edit.
*/
add_filter(  'gettext',  'translate_word_replacements' );
add_filter(  'ngettext',  'translate_word_replacements' );
function translate_word_replacements( $translated ) {
    // Set the path to the word replacements file.
    $jsonPath = plugin_dir_path( __FILE__ ) . 'includes/word-replacement-filters.json';

    // Read the replacements json file from disk.
    $jsonString = file_get_contents($jsonPath);    

    // Decode the json data to an array.
    $jsonData = json_decode($jsonString, true);

    // Translate the words and return the result.
    return str_replace( array_keys($jsonData), $jsonData, $translated );
}

/**
* This tweakes the names of wordpress roles we can't edit.
*/
add_action( 'wp_roles_init', static function ( \WP_Roles $roles ) {
    // Override the default 'subscriber' role to 'member'.
    $roles->roles['subscriber']['name'] = 'Member';
    $roles->role_names['subscriber']    = 'Member';
} );

/**
* This removes permissions from all user groups, used to purge old data from the database.
* (Notice: This will irriversibly delete data, do not use this unless abasolutely sure.)
*/
add_action( 'wp_roles_init', static function ( \WP_Roles $roles ) {
    // Defines a list of permissions to remove.
	$remove_permissions = array(
		
    );

    // Stop if we don't have any permissions to remove.
    if(count($remove_permissions) < 1) { return; }

    // Remove the permissions from each user role.
	foreach ($remove_permissions as $permission) {
		foreach (array_keys($roles->roles) as $role) {
			$roles->remove_cap($role, $permission);
		}
	}
} );