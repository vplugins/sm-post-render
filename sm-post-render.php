<?php
/**
 * Plugin Name: SM Post Render
 * Description: A custom WordPress plugin with a settings page for AG-ID.
 * Version: 1.0.0
 * Author: Website Pro Team
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin path
define('SM_POST_RENDER_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Load Composer autoloader dynamically
if (file_exists(SM_POST_RENDER_PLUGIN_PATH . 'vendor/autoload.php')) {
    require_once SM_POST_RENDER_PLUGIN_PATH . 'vendor/autoload.php';
} else {
    wp_die('Composer autoload file not found. Please run `composer install`.');
}

use SMPostRender\Admin\SettingsPage;
use SMPostRender\Shortcode\PostShortcode;


if (is_admin()) {
    $settingsPage = new SettingsPage();
}

$postShortcode = new PostShortcode();
$postShortcode->register();
