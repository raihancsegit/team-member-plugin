<?php

/**
 *
 * @link              https://raihan.website
 * @since             1.0.0
 * @package           Team_members_orbit_technology
 *
 * @wordpress-plugin
 * Plugin Name:       Team Members Orbit Technology
 * Plugin URI:        https://raihan.website
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Raihan Islam
 * Author URI:        https://raihan.website/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       team_members_orbit_technology
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
define( 'TEAM_MEMBERS_ORBIT_TECHNOLOGY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-team_members_orbit_technology-activator.php
 */
function activate_team_members_orbit_technology() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-team_members_orbit_technology-activator.php';
	Team_members_orbit_technology_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-team_members_orbit_technology-deactivator.php
 */
function deactivate_team_members_orbit_technology() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-team_members_orbit_technology-deactivator.php';
	Team_members_orbit_technology_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_team_members_orbit_technology' );
register_deactivation_hook( __FILE__, 'deactivate_team_members_orbit_technology' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-team_members_orbit_technology.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_team_members_orbit_technology() {

	$plugin = new Team_members_orbit_technology();
	$plugin->run();

}
run_team_members_orbit_technology();