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
			require_once plugin_dir_path( __FILE__ ) . 'inc/class.authors-posttype.php';
			require_once plugin_dir_path( __FILE__ ) . 'inc/class.authors-meta.php';

			add_filter( 'template_include', [ $this, 'singleAuthorsTemplateInclude' ], 99 );
			add_action( 'admin_enqueue_scripts', [ $this, 'loadAdminStyles' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'loadPublicStyles' ] );
			add_action( 'admin_init', [ $this, 'hideTitleAndEditor' ] );
			add_filter( 'the_title', [ $this, 'postTitleAsAuthorName' ], 10, 2 );

			flush_rewrite_rules();
		}

		public function deactivate() {
			flush_rewrite_rules();
		}

		/**
		 * Hide title and editor input fields from standard admin view
		 */
		public function hideTitleAndEditor() {
			remove_post_type_support( 'authors', 'title' );
		}

		/**
		 *
		 * Filter posts to make them display author names as titles
		 *
		 * @param $title
		 * @param $post_id
		 *
		 * @return mixed
		 */
		public function postTitleAsAuthorName( $title, $post_id ) {
			if ( is_admin() && get_post_type() == 'authors' ) {
				$title = get_post_meta( $post_id, '_author_name_meta_key', true );
			}

			return $title;
		}

		/**
		 * Load css styles for admin panel only and only for 'authors' post type
		 */
		public function loadAdminStyles() {
			if ( get_post_type() == 'authors' ) {
				wp_enqueue_style( 'author-manager-css', plugins_url( 'admin/style.css', __FILE__ ) );
			}
		}

		/**
		 * Load css styles for frontend only
		 */
		public function loadPublicStyles() {
			wp_enqueue_style( 'public-author-manager-css', plugins_url( 'public/style.css', __FILE__ ) );
		}


		public function singleAuthorsTemplateInclude( $template ) {
			if ( get_post_type() == 'authors' ) {
				$singleAuthorTemplate = plugin_dir_path( __FILE__ ) . 'templates/single-authors.php';
				if ( '' != $singleAuthorTemplate ) {
					return $singleAuthorTemplate;
				}
			}

			return $template;
		}
	}
}

$authorsManager = new AuthorsManager();
