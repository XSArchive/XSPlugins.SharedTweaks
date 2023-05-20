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
