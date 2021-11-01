<?php
/**
 * @package WP-RetroGaming
 * @version 1.0
 */
/*
Plugin Name: WP-RetroGaming
Plugin URI: https://github.com/gwannon/WP-RetroGaming
Description: With this plugin you can admin your retrogaming collection in your webpage with Wordpress
Version: 1.0
Author: gwannon
Author URI: https://github.com/gwannon
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

flush_rewrite_rules(true);

// Includes --------------------------------
// -----------------------------------------
include_once(dirname(__FILE__)."/custom_posts/accessories.php");
include_once(dirname(__FILE__)."/custom_posts/devices.php");
include_once(dirname(__FILE__)."/lib/custom_posts.php");