<?php
/*
Plugin Name: Custom Post Type Json Setup
Plugin URI: http://wordpress.org/plugins/custom-post-type-json-setup/
Version: 0.7.1
Description: set up a post from a JSON file
Author: Webnist
Author URI: http://profiles.wordpress.org/webnist
Text Domain: custom-post-type-json-setup
Domain Path: /languages
*/
if ( ! class_exists('CustomPostTypeJsonSetup') )
	require_once( dirname( __FILE__ ) . '/includes/custom-post-type-json-setup.php' );

class CustomPostTypeJsonSetupInit {

	public function __construct() {
		$this->basename        = dirname( plugin_basename(__FILE__) );
		$this->dir             = plugin_dir_path( __FILE__ );
		$this->url             = plugin_dir_url( __FILE__ );
		$headers               = array(
			'name'        => 'Plugin Name',
			'version'     => 'Version',
			'domain'      => 'Text Domain',
			'domain_path' => 'Domain Path',
		);
		$data                  = get_file_data( __FILE__, $headers );
		$this->name            = $data['name'];
		$this->version         = $data['version'];
		$this->domain          = $data['domain'];
		$this->domain_path     = $data['domain_path'];
		$this->post_type_json  = '';
		$this->taxonomies_json = '';
		if ( file_exists( $this->content_dir( 'post-type.json' ) ) ) {
			$this->post_type_json = $this->content_dir( 'post-type.json' );
		} elseif ( file_exists( get_template_directory() . '/post-type.json' ) ) {
			$this->post_type_json = get_template_directory() . '/post-type.json';
		}
		if ( file_exists( $this->content_dir( 'taxonomies.json' ) ) ) {
			$this->taxonomies_json = $this->content_dir( 'taxonomies.json' );
		} elseif ( file_exists( get_template_directory() . '/taxonomies.json' ) ) {
			$this->taxonomies_json = get_template_directory() . '/taxonomies.json';
		}
		load_plugin_textdomain( $this->domain, false, $this->basename . $this->domain_path );
	}

	public function content_dir( $path = '' ) {
		$url = set_url_scheme( WP_CONTENT_DIR );

		if ( $path && is_string( $path ) )
			$url .= '/' . ltrim($path, '/');

		return apply_filters( 'content_dir', $url, $path );
	}
}
new CustomPostTypeJsonSetupInit();
new CustomPostTypeJsonSetup();
