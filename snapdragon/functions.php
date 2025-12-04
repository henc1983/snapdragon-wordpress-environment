<?php
/**
 * Snapdragon engine room
 *
 * @package snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');

defined( 'THEME_VERSION' ) or define( 'THEME_VERSION' , wp_get_theme()->get('Version') );
defined( 'THEME_DIR' ) or define( 'THEME_DIR' , untrailingslashit( get_template_directory() ) );
defined( 'THEME_URI' ) or define( 'THEME_URI' , untrailingslashit( get_template_directory_uri() ) );



/**
 * Start Theme Engine
 */
require_once THEME_DIR . '/inc/snapdragon.php';
Snapdragon::instance();