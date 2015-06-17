<?php
class CustomPostTypeJsonSetup extends CustomPostTypeJsonSetupInit {

	public function __construct() {
		parent::__construct();
		add_action( 'init', array( $this, 'post_type_init' ) );
		add_action( 'init', array( $this, 'taxonomies_init' ) );

	}
	function post_type_init() {
		if ( empty( $this->post_type_json ) )
			return;

		$post_type_data = json_decode( file_get_contents( $this->post_type_json ), true );

		if ( empty( $post_type_data ) && ! array_key_exists( 'post_type', $post_type_data ) )
			return;

		$post_types = $post_type_data['post_type'];
		foreach ( $post_types as $key => $value ) {
			extract( $value );
			$post_type  = $key;
			$label_name = $label;
			$this->register_custom_post_type( $label_name, $post_type, $value );
		}
	}

	function taxonomies_init() {
		if ( empty( $this->taxonomies_json ) )
			return;

		$taxonomies_data = json_decode( file_get_contents( $this->taxonomies_json ), true );

		if ( empty( $taxonomies_data ) && ! array_key_exists( 'taxonomies', $taxonomies_data ) )
			return;

		$taxonomies = $taxonomies_data['taxonomies'];
		foreach ( $taxonomies as $key => $value ) {
			extract( $value );
			$taxonomy   = $key;
			$label_name = $label;
			$post_type  = $post_type;
			$this->register_custom_taxonomies( $label_name, $taxonomy, $post_type, $value );
		}
	}

	function register_custom_post_type( $label_name, $post_type, $args = array() ) {

		$labels = array(
			'name'               => sprintf( __( '%s', $this->domain ), $label_name ),
			'singular_name'      => sprintf( __( '%s', $this->domain ), $label_name ),
			'add_new'            => sprintf( __( 'Add New', $this->domain ), $label_name ),
			'add_new_item'       => sprintf( __( 'Add New %s', $this->domain ), $label_name ),
			'edit_item'          => sprintf( __( 'Edit %s', $this->domain ), $label_name ),
			'new_item'           => sprintf( __( 'New %s', $this->domain ), $label_name ),
			'view_item'          => sprintf( __( 'View %s', $this->domain ), $label_name ),
			'search_items'       => sprintf( __( 'Search %s', $this->domain ), $label_name ),
			'not_found'          => sprintf( __( 'No %s found.', $this->domain ), $label_name ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash.', $this->domain ), $label_name ),
			'parent_item_colon'  => sprintf( __( 'Parent %s:', $this->domain ), $label_name ),
			'all_items'          => sprintf( __( 'All %s', $this->domain ), $label_name ),
			'name_admin_bar'     => sprintf( __( '%s', $this->domain ), $label_name ),
		);

		$defaults = array(
			'labels'   => $labels,
			'public'   => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'page-attributes', 'custom-fields', 'comments', 'revisions', 'post-formats' ),
		);
		$r = wp_parse_args( $args, $defaults );
		register_post_type( $post_type, $r );
	}

	function register_custom_taxonomies( $label_name = '', $taxonomy = '', $post_type = '', $args = array() ) {

		$labels = array(
			'name'                       => sprintf( __( '%s', $this->domain ), $label_name ),
			'singular_name'              => sprintf( __( '%s', $this->domain ), $label_name ),
			'search_items'               => sprintf( __( 'Search %s', $this->domain ), $label_name ),
			'popular_items'              => sprintf( __( 'Popular %s', $this->domain ), $label_name ),
			'all_items'                  => sprintf( __( 'All %s', $this->domain ), $label_name ),
			'parent_item'                => sprintf( __( 'Parent %s', $this->domain ), $label_name ),
			'parent_item_colon'          => sprintf( __( 'Parent %s:', $this->domain ), $label_name ),
			'edit_item'                  => sprintf( __( 'Edit %s', $this->domain ), $label_name ),
			'view_item'                  => sprintf( __( 'View %s', $this->domain ), $label_name ),
			'update_item'                => sprintf( __( 'Update %s', $this->domain ), $label_name ),
			'add_new_item'               => sprintf( __( 'Add New %s', $this->domain ), $label_name ),
			'new_item_name'              => sprintf( __( 'New %s Name', $this->domain ), $label_name ),
			'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', $this->domain ), $label_name ),
			'add_or_remove_items'        => sprintf( __( 'Add or remove %s', $this->domain ), $label_name ),
			'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s', $this->domain ), $label_name ),
			'not_found'                  => sprintf( __( 'No %s found.', $this->domain ), $label_name ),
		);

		$defaults = array(
			'labels'       => $labels,
			'hierarchical' => true,
		);
		$r = wp_parse_args( $args, $defaults );
		register_taxonomy( $taxonomy, $post_type, $r );
	}

}
