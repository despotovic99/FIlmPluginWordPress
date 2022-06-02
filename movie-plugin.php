<?php

/*
 * Plugin Name: Movies Plugin
 * Description:  Movies....
 * Version: 1.0.0
 * Text Domain: movie-plugin
 * Domain Path: /i18n/languages
 * Author: Nemanja
 * Requires at least: 4.6
 * */

if (!defined('ABSPATH')) {
    exit;
}
require_once plugin_dir_path(__FILE__) . '/vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . 'FilmPlugin.php';

define('FILES_DIR', plugin_dir_path(__FILE__) . '/temp-files');

global $wpdb;

$plugin = new FilmPlugin(__FILE__);
$plugin->initialize();

