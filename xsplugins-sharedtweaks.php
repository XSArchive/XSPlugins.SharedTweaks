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
* This hides the login and password fields so only the social login buttons are visible
*/
add_action( 'login_head', 'xershade_hide_login_form' );
function xershade_hide_login_form() {
    $style = '';
    $style .= '<style type="text/css">';
    $style .= '.login form{ padding: 24px }';
    $style .= '.login label{ display: none }';
    $style .= '.login .button.wp-hide-pw .dashicons{ display: none }';
    $style .= '.login form .input{ display: none }';
    $style .= '.login form .submit{ display: none }';
    $style .= '.login form .forgetmenot{ display: none }';
    $style .= '.login #nav a { display: none }';
    $style .= '.login #backtoblog a { display: block }';
    $style .= '</style>';

    echo $style; 
}

/**
* This styles the social login buttons, because I'm not paying $70 for a plugin that does it.
*/
add_action( 'login_head', 'xershade_social_login_tweaks' );
function xershade_social_login_tweaks() {
    $style = '';
    $style .= '<style type="text/css">';
    $style .= '.heateor_sl_title { display: block; margin-bottom: 1em; }';
    $style .= '.heateor_sl_optin_container label{ display: block; margin-top: 1.2em; }';
    $style .= 'ul.heateor_sl_login_ul li { width: 100% !important; }';
    $style .= '.heateorSlLogin { width: 100%;  height: 3em !important; }';
    $style .= '.heateorSlLoginSvg { background-position: 3% !important; }';
    $style .= '.heateorSlLoginSvg:after { position: relative; top: 25%; left: 25%; color: white; font-weight: bold; text-decoration: none; font-style: normal; }';
    $style .= '.heateorSlDiscordLoginSvg:after { content: "Login With Discord"; }';
    $style .= '.heateorSlGithubLoginSvg { background-size: initial; }';
    $style .= '.heateorSlGithubLoginSvg:after { content: "Login With GitHub"; }';
    $style .= '</style>';

    echo $style; 
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