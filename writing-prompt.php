<?php
/*
  Plugin Name: Writing Prompt
  Description: Daily writing prompts served directly to your Wordpress site via <a href="http://thewritepractice.com">The Write Practice</a>.
  Author: Rob Skidmore
  Author URI: http://robskidmore.me
  Version: 1.0.0
  License: GPLv3
 */

  // Exit if accessed directly
if (!defined('ABSPATH')) {
   exit;
}

if (!class_exists( 'Writing_Prompt' )) {

	class Writing_Prompt {

		// Plugin version
		const VERSION = "1.0.0";

		// Set plugin slug
		protected $plugin_slug = 'writing-prompt';

		// Construct plugin
		public function __construct() {

			// Call the load files function
			$this->load_files();

			// Enqueue styles
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		}

		// Get plugin slug
		public function get_plugin_slug() {

			return $this->plugin_slug;

		}

		// Load files
		private function load_files() {

			require_once( 'assets/admin.php' );

		}

		// Enqueue styles
		public function enqueue_styles() {

			if( is_admin() ) {

				wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/writing-prompt.css', __FILE__ ), array(), self::VERSION );

			}

		}

	}

}

// New instance of Slee_Testimonials
global $Writing_Prompt;
$Writing_Prompt = new Writing_Prompt();
