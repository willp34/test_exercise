<?php
/*
Plugin Name:  Mr B & Friends Job Feed
Plugin URI:
Description:  Code test Plugin.
Version:      1.0.0
Author:       Mr B and Friends
Author URI:   http://www.mrbandfriends.co.uk
License:      Restricted
*/

namespace MrB;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin Autoloader
require_once __DIR__.'/autoloader.php';


// Grab the core Plugin class
$core = Core::class;

//  Initialise
add_action('plugins_loaded', [$core, 'initialise']);



	//add js
		add_action('wp_enqueue_scripts',[$core,'my_js_files']);
		
		//ajax handler
		add_action('wp_ajax_mrb_job_upload', [$core,'handle_application_upload']);
		
		