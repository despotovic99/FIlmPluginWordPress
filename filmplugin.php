<?php

/*
 * Plugin Name: Filmovi Plugin
 * Description:  Filmovi....
 * Version: 1.0.0
 * Author: ~
 * */

if (!defined('ABSPATH')) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
require_once plugin_dir_path(__FILE__).'FilmPlugin.php';

global $wpdb;

FilmPlugin::init();

