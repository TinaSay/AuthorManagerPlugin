<?php
/**
 * Plugin Name:       Authors Manager
 * Description:       Handles adding new authors, linking them with existing users and display on front end.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Valentina Sayapina
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       authors-manager
 */
/**
 * Authors Manager is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Authors Manager is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Authors Manager. If not, see {URI to Plugin License}.
 */

/**
 * Restrict direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access this file directly' );
}

if ( ! class_exists( 'AuthorsManager' ) ) {
	class AuthorsManager {

		public function __construct() {
			register_activation_hook( __FILE__, [ $this, 'activate' ] );
			register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
			$this->activate();
		}

		public function activate() {
			add_action( 'init', [ $this, 'add_authors_post_type' ] );
		}

		public function deactivate() {
			flush_rewrite_rules();
		}

		/**
		 * Adds 'Authors' custom post type
		 */
		public function add_authors_post_type() {

			$labels = array(
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

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'rewrite'            => array( 'slug' => 'authors' ),
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
			);

			register_post_type( 'tttp_authors', $args );
		}

	}
}

$authorsManager = new AuthorsManager();