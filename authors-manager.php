<?php
/**
 * Plugin Name:       Authors Manager
 * Description:       Handles adding new authors, linking them with existing users and display on front end.
 * Version:           1.0.0
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

		/**
		 * AuthorsManager constructor.
		 */
		public function __construct() {
			register_activation_hook( __FILE__, [ $this, 'activate' ] );
			register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

			$this->activate();
		}

		/**
		 * Load necessary classes, enqueue styles, include template
		 */
		public function activate() {
			require_once plugin_dir_path( __FILE__ ) . 'inc/class.authors-posttype.php'; // Creates post type
			require_once plugin_dir_path( __FILE__ ) . 'inc/class.authors-meta.php'; // Creates meta fields
			require_once plugin_dir_path( __FILE__ ) . 'inc/class.admin-ui.php'; // Admin panel UI
			require_once plugin_dir_path( __FILE__ ) . 'inc/class.authors-widget.php'; // Admin panel UI

			// Including templates
			add_filter( 'template_include', [ $this, 'singleAuthorsTemplateInclude' ], 99 );

			// Enqueueing scripts and styles
			add_action( 'admin_enqueue_scripts', [ $this, 'loadAdminStyles' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'loadPublicStyles' ] );

			// Modify post title and post name according to author name
			add_filter( 'wp_insert_post_data', [ $this, 'modifyPostTitle' ], '99', 1 );

			// Allow only images for upload
			add_filter( 'upload_mimes', [ $this, 'custom_mime_types' ], 1, 1 );

			// Register Widget
			add_action( 'widgets_init', function () {
				register_widget( 'AuthorsWidget' );
			} );

			flush_rewrite_rules();
		}

		public function deactivate() {
			flush_rewrite_rules();
		}


		/**
		 * Load css styles for admin panel only and only for 'ttp_authors' post type
		 */
		public function loadAdminStyles() {
			if ( get_post_type() == 'ttp_authors' ) {
				wp_enqueue_style( 'author-manager-css',
					plugins_url( 'admin/css/style.css', __FILE__ ) );
			}
		}

		/**
		 * Load css styles for frontend only
		 */
		public function loadPublicStyles() {
			if ( get_post_type() == 'ttp_authors' ) {
				wp_enqueue_style( 'public-author-manager-css',
					plugins_url( 'public/css/style.css', __FILE__ ) );
			}
		}

		/**
		 * Load templates for archive and single files
		 */
		public function singleAuthorsTemplateInclude( $template ) {
			if ( get_post_type() == 'ttp_authors' ) {

				if ( is_archive() ) {
					return plugin_dir_path( __FILE__ ) . 'public/templates/archive-authors.php';
				} elseif ( is_singular( 'ttp_authors' ) ) {
					return plugin_dir_path( __FILE__ ) . 'public/templates/single-authors.php';
				}
			}

			return $template;
		}

		/**
		 * Modify post title and post name to look it like firstname-lastname
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function modifyPostTitle( $data ) {
			if ( $data['post_type'] == 'ttp_authors' ) {

				if ( ! empty( $_POST['author_name'] ) && ! empty( $_POST['author_lastname'] ) ) {
					$firstname = $_POST['author_name'];
					$lastname  = $_POST['author_lastname'];
					if ( preg_match( '/\s/', $firstname ) ) {
						$firstname = str_replace( ' ', '_', $firstname );
					}
					if ( preg_match( '/\s/', $lastname ) ) {
						$lastname = str_replace( ' ', '_', $lastname );
					}
					$title              = $firstname . '-' . $lastname;
					$data['post_title'] = $title;
					$data['post_name']  = $title;
				}
			}

			return $data;
		}


		/**
		 * Allow only images to upload
		 *
		 * @param $mimes
		 *
		 * @return mixed
		 */
		public function custom_mime_types( $mimes ) {
			// Forbiden ALL
			unset( $mimes );
			// OK gif, png, jpg
			$mimes['jpg|jpeg|jpe'] = 'image/jpeg';
			$mimes['gif']          = 'image/gif';
			$mimes['png']          = 'image/png';
			// List mime types available here
			// https://codex.wordpress.org/Function_Reference/get_allowed_mime_types
			return $mimes;
		}
	}

	$authorsManager = new AuthorsManager();
}
