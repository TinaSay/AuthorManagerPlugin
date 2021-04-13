<?php

/**
 * Class Authors_Meta
 * Add meta fields for 'authors' post type
 */
if ( ! class_exists( 'Authors_Meta' ) ) {

	abstract class Authors_Meta {

		/**
		 * Set up and add the meta box.
		 */
		public static function add() {
			add_meta_box(
				'author_info',          // Unique ID
				'Authors info', // Box title
				[ self::class, 'html' ],   // Content callback, must be of type callable
				'authors',
				'test',
				'high'
			);
		}


		public static function save( $post_id ) {

			if ( array_key_exists( 'author_name', $_POST ) ) {
				update_post_meta(
					$post_id,
					'_author_name_meta_key',
					sanitize_text_field( $_POST['author_name'] )
				);
			}
			if ( array_key_exists( 'author_lastname', $_POST ) ) {
				update_post_meta(
					$post_id,
					'_author_lastname_meta_key',
					trim( sanitize_text_field( $_POST['author_lastname'] ) )
				);
			}

			if ( array_key_exists( 'author_bio', $_POST ) ) {
				update_post_meta(
					$post_id,
					'_author_bio_meta_key',
					sanitize_textarea_field( trim( $_POST['author_bio'] ) )
				);
			}

			if ( array_key_exists( 'author_fb_url', $_POST ) ) {
				update_post_meta(
					$post_id,
					'_author_fb_meta_key',
					esc_url( $_POST['author_fb_url'] )
				);
			}

			if ( array_key_exists( 'author_linkedin_url', $_POST ) ) {
				update_post_meta(
					$post_id,
					'_author_linkedin_meta_key',
					esc_url( $_POST['author_linkedin_url'] )
				);
			}

			if ( array_key_exists( 'linked_user', $_POST ) ) {
				update_post_meta(
					$post_id,
					'_linked_user_meta_key',
					intval( $_POST['linked_user'] )
				);
			}

		}


		/**
		 * Display the meta box HTML to the user.
		 **/
		public static function html() {
			include plugin_dir_path( __FILE__ ) . '../admin/templates/meta-fields-template.php';
		}
	}

	add_action( 'add_meta_boxes', [ 'Authors_Meta', 'add' ], 1 );
	add_action( 'save_post', [ 'Authors_Meta', 'save' ] );
}
