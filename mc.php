<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              
 * @since             1.0.0
 * @package           MC
 *
 * @wordpress-plugin
 * Plugin Name:       MC Companion
 * Plugin URI:        
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Masum Sakib
 * Author URI:        
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mc
 * Domain Path:      
 */


// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/*
Constants
------------------------------------------ */

/* Set plugin version constant. */
define( 'MC_VERSION', '0.1');

/* Set constant path to the plugin directory. */
define( 'MC_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

// Plugin Addons Folder Path
define( 'MC_ADDONS_DIR', plugin_dir_path( __FILE__ ) . 'widget/' );
define( 'MC_ADDONS_ASSETS', plugins_url( 'assets', __FILE__ ) );




require_once(MC_PATH. 'base.php' );