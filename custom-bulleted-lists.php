<?php

/*
Plugin Name: Custom Bulleted Lists
Plugin URI: 
Description: Use Custom Bullet lists in your WordPress posts and pages with attractive and colofrul icons and write visually engaging content.
Version: 1.0
Author: Janmejai Pratap Singh
Author URI: https://abcofwp.com/
License: GPLv2 or later
*/


add_action('admin_head', 'wcb_buttons');
function wcb_buttons() {
  //Check User Permissions
  if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
    return;
  }
  //Check if WYSIWYG is enabled
  if ( 'true' == get_user_option( 'rich_editing' ) ) {
    add_filter( 'mce_external_plugins', 'wcb_add_tinymce_plugin' );
    add_filter( 'mce_buttons', 'wcb_register_button' );
  }
}

//Register a button in WYSIWYG editor
function wcb_register_button( $buttons ) {
  array_push( $buttons, 'wc_bullet_button' );
  return $buttons;
}

// script for the new button
function wcb_add_tinymce_plugin( $plugin_array ) {
  $plugin_array['wc_bullet_button'] = plugins_url( '/js/wcb-buttons.js', __FILE__ );
  return $plugin_array;
}

//Enqueue the Dashicons script
add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}

//css style for icons in post editor options
function wcb_editor_css() {
    wp_enqueue_style('wcb-editor-css', plugins_url('/css/style.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'wcb_editor_css');

//frontend css
add_action( 'wp_enqueue_scripts', 'wc_button_css' );
function wc_button_css() {
  if ( !is_admin()) {
    wp_enqueue_style('wcb-css', plugins_url('/css/style.css', __FILE__));
  }
}

//CSS for post editor
add_filter( 'mce_css', 'wcbeditor_styles' );
function wcbeditor_styles( $mce_css ){
  $mce_css .= ', ' . plugins_url( '/css/style.css', __FILE__ );
  return $mce_css;
}

?>
