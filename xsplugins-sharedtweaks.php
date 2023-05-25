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
function enqueue_login_tweaks() {
    wp_enqueue_style( 'wordpress.login.tweaks', plugins_url( 'css/wordpress.login.tweaks.css' , __FILE__ ) );
    wp_enqueue_style( 'social.login.tweaks', plugins_url( 'css/social.login.tweaks.css' , __FILE__ ) );
}

/**
* This replaces words in the administartor panels and other wordpress components we can't edit.
*/
add_filter(  'gettext',  'wps_translate_words_array' );
add_filter(  'ngettext',  'wps_translate_words_array' );
function wps_translate_words_array( $translated ) {
    // Define a list of words to be translated.
    $words = array(
        // 'words to translate' = > 'translation'
        'super admin' => 'network administrator',
        'Super Admin' => 'Network Administrator',

        // Potential partial word replace filter fixes.
        'istratoristrator' => 'istrator',
    );

    // Translate the words and return the result.
    return str_replace( array_keys($words), $words, $translated );
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