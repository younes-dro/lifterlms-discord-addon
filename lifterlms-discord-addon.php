<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.expresstechsoftwares.com
 * @since             1.0.0
 * @package           Lifterlms_Discord_Addon
 *
 * @wordpress-plugin
 * Plugin Name:       Connect LifterLMS to Discord
 * Plugin URI:        https://www.expresstechsoftwares.com/?page_id=18295&preview=true
 * Description:       Create an engaging community/forum of your LifterLMS online courses, sell private content. Discord is the #1 tool for students to learn in groups, chat and video.
 * Version:           1.0.10
 * Author:            ExpressTech Softwares Solutions Pvt Ltd
 * Author URI:        https://www.expresstechsoftwares.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       connect-lifterlms-discord
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LIFTERLMS_DISCORD_ADDON_VERSION', '1.0.4' );

/**
 * Define Plugin Dir Constant
 */

/**
 * Discord API URL
 */
define( 'LIFTERLMS_DISCORD_API_URL', 'https://discord.com/api/v10/' );

/**
 * Discord BOT Permissions
 */

define( 'LIFTERLMS_DISCORD_BOT_PERMISSIONS', 8 );


/**
 * Discord API call scopes
 */
define( 'LIFTERLMS_DISCORD_OAUTH_SCOPES', 'identify email guilds guilds.join' );

/**
 * Follwing response codes not cosider for re-try API calls.
 */
define( 'LIFTERLMS_DISCORD_DONOT_RETRY_THESE_API_CODES', array( 0, 10003, 50033, 10004, 50025, 10013, 10011 ) );

/**
 * Define plugin directory url
 */
define( 'LIFTERLMS_DISCORD_DONOT_RETRY_HTTP_CODES', array( 400, 401, 403, 404, 405, 502 ) );
/**
 * LIFTERLMS_DISCORD_PLUGIN_DIR_PATH
 */
define( 'LIFTERLMS_DISCORD_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Define group name for action scheduler actions
 */
define( 'LIFTERLMS_DISCORD_AS_GROUP_NAME', 'ets-lifterlms-discord' );

/**
 * Define plugin directory URL
 */
define( 'LIFTERLMS_DISCORD_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lifterlms-discord-addon-activator.php
 */
function activate_lifterlms_discord_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lifterlms-discord-addon-activator.php';
	Lifterlms_Discord_Addon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lifterlms-discord-addon-deactivator.php
 */
function deactivate_lifterlms_discord_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lifterlms-discord-addon-deactivator.php';
	Lifterlms_Discord_Addon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lifterlms_discord_addon' );
register_deactivation_hook( __FILE__, 'deactivate_lifterlms_discord_addon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lifterlms-discord-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lifterlms_discord_addon() {
	$plugin = new Lifterlms_Discord_Addon();
	$plugin->run();
}
run_lifterlms_discord_addon();
