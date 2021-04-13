<?php

/**
 * Class Authors_Meta
 * Add meta fields for 'ttp_authors' post type
 */
if ( ! class_exists( 'Authors_Meta' ) ) {

	abstract class Authors_Meta {

		/**
		 * Set up and add the meta box.
		 */
		public static function add() {
			add_meta_box(
				'author_info',
				'Authors info',
				[ self::class, 'html' ],
				'ttp_authors'
			);
		}


		/**
		 * Save input values
		 *
		 * @param $post_id
		 */
		public static function save( $post_id ) {

			if ( current_user_can( 'edit_posts' ) && ! empty( $_POST ) &&
			     check_admin_referer( 'meta_save_action', 'meta_nonce_field' )  ) {

				if ( array_key_exists( 'author_name', $_POST ) ) {
					$firstname = sanitize_text_field( $_POST['author_name'] );

					if ( isset( $firstname ) && ! empty( $firstname ) && strlen( $firstname ) > 1 ) {
						update_post_meta(
							$post_id,
							'_author_name_meta_key',
							$firstname
						);
					}
				}

				if ( array_key_exists( 'author_lastname', $_POST ) ) {
					$lastname = sanitize_text_field( $_POST['author_lastname'] );

					if ( isset( $lastname ) && ! empty( $lastname ) && strlen( $lastname ) > 1 ) {
						update_post_meta(
							$post_id,
							'_author_lastname_meta_key',
							$lastname
						);
					}
				}

				if ( array_key_exists( 'author_bio', $_POST ) ) {
					$bio = sanitize_textarea_field( $_POST['author_bio'] );
					if ( isset( $bio ) && ! empty( $bio ) && strlen( $bio ) > 1 ) {
						update_post_meta(
							$post_id,
							'_author_bio_meta_key',
							$bio
						);
					}
				}

				if ( array_key_exists( 'author_fb_url', $_POST ) ) {
					$fbUrl = esc_url_raw( $_POST['author_fb_url'] );
					if ( isset( $fbUrl ) && ! empty( $fbUrl ) && strlen( $fbUrl ) > 3 ) {
						update_post_meta(
							$post_id,
							'_author_fb_meta_key',
							$fbUrl
						);
					}
				}

				if ( array_key_exists( 'author_linkedin_url', $_POST ) ) {
					$linkedInUrl = esc_url_raw( $_POST['author_linkedin_url'] );
					if ( isset( $linkedInUrl ) && ! empty( $linkedInUrl ) && strlen( $linkedInUrl ) > 3 ) {
						update_post_meta(
							$post_id,
							'_author_linkedin_meta_key',
							$linkedInUrl
						);
					}
				}

				if ( array_key_exists( 'linked_user', $_POST ) ) {
					$linkedUser = intval( $_POST['linked_user'] );
					if ( isset( $linkedUser ) && ! empty( $linkedUser ) ) {
						update_post_meta(
							$post_id,
							'_linked_user_meta_key',
							$linkedUser
						);
					}
				}

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
