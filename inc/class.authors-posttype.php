<?php

/**
 * Class Authors_Posttype
 * Registers and adds 'ttp_authors' post type
 */
if ( ! class_exists( 'Authors_Posttype' ) ) {

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
		 * Registers 'ttp_authors' custom post type
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
				'supports'           => array( 'thumbnail' ),
				'has_archive'        => 'authors',
				'rewrite'            => array( 'slug' => 'authors', 'with_front' => false ),
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'          => 'dashicons-buddicons-buddypress-logo',

				'register_meta_box_cb' => [ 'Authors_Meta', 'my_meta_box_cb' ]
			);

			register_post_type( 'ttp_authors', $args );
		}
	}

	add_action( 'init', [ 'Authors_Posttype', 'add' ] );


}
