<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://raihan.website
 * @since      1.0.0
 *
 * @package    Team_members_orbit_technology
 * @subpackage Team_members_orbit_technology/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Team_members_orbit_technology
 * @subpackage Team_members_orbit_technology/includes
 * @author     Raihan Islam <raihanislam.cse@gmail.com>
 */
class Team_members_orbit_technology_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'team_members_orbit_technology',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
