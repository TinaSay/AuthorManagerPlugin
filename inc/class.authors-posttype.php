<?php

/**
 * Class Authors_Posttype
 * Registers and adds 'Authors' post type
 */

abstract class Authors_Posttype {

	/**
	 * @var array
	 * Labels for Authors post type
	 */
	public static $labels = array(
		'name'           => 'Authors',
		'singular_name'  => 'Author',
		'menu_name'      => 'Authors',
		'name_admin_bar' => 'Authors',
		'add_new'        => 'Add New',
		'add_new_item'   => 'Add New Author',
		'new_item'       => 'New Author',
		'edit_item'      => 'Edit Author',
		'view_item'      => 'View Author',
		'all_items'      => 'All Authors'
	);

	/**
	 * Registers 'Authors' custom post type
	 */
	public static function add() {

		$args = array(
			'labels'             => self::$labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'supports'           => array( 'thumbnail','editor' ),
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'authors' ),
			'hierarchical'       => false,
			'menu_position'      => null,
		);

		register_post_type( 'authors', $args );
	}
}

add_action( 'init', [ 'Authors_Posttype', 'add' ] );
