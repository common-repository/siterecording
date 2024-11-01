<?php
/*
Plugin Name: SiteRecording
Plugin URI: https://siterecording.com/
Author: 500apps
Author URI: https://500apps.com
Version: 0.1
Description: Record the entire visitor's journey across your website.
 */

define('siterecordingfile_root', __FILE__);
define('siterecording_DIR', plugin_dir_path(__FILE__));

require __DIR__ . '/siterecording_functions.php';
spl_autoload_register('siterecording_class_loader');

/**
 * Parse configuration
 */
$settings_siterecording = parse_ini_file(__DIR__ . '/siterecording_settings.ini', true);
add_action('plugins_loaded', array(\siterecordingplugin\Siterecording::$class, 'init'));

add_action('wp_enqueue_scripts', 'siterecording_stylesheet');
add_action('admin_enqueue_scripts', 'siterecording_stylesheet');
function siterecording_stylesheet() 
{
    wp_enqueue_style( 'siterecording_CSS', plugins_url( '/siterecording.css', __FILE__ ) );
}

function siterecording_scripts(){
    wp_register_script('siterecording_script', plugins_url('/js/siterecording_admin.js', siterecordingfile_root), array('jquery'),time(),true);
    wp_enqueue_script('siterecording_script');
}    

add_action('wp_enqueue_scripts', 'siterecording_scripts');
add_action('admin_enqueue_scripts', 'siterecording_scripts');
add_action( 'wp_head', 'siterecording_script' );

add_action('wp_ajax_siterecording_addtoken', 'siterecording_addtoken');
add_action('wp_ajax_siterecording_save_website', 'siterecording_save_website');