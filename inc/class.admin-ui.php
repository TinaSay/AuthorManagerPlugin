<?php
/**
 * Class takes care of slight admin panel UI changes
 */
if ( ! class_exists( 'Admin_Ui' ) ) {

	class Admin_Ui {
		/**
		 * Hide title and editor field from standard admin view
		 */
		public static function hideTitle() {
			remove_post_type_support( 'ttp_authors', 'title' );
			remove_post_type_support( 'ttp_authors', 'editor' );
		}

		// Add the custom columns to the authors post type:
		public static function set_custom_ttp_authors_columns( $columns ) {
			unset( $columns['date'] );
			$columns['firstname'] = __( 'First Name' );
			$columns['lastname']  = __( 'Last Name' );
			$columns['fbUrl']     = __( 'FB address' );
			$columns['linkedIn']  = __( 'LinkedIn' );
			$columns['date']      = __( 'Published' );

			return $columns;
		}

		public static function custom_ttp_authors_column( $column, $post_id ) {
			require_once 'class.meta-values.php';
			$authorInfo = new Meta_Values( $post_id );
			switch ( $column ) {

				case 'firstname' :
					esc_html_e( $authorInfo->firstname );
					break;
				case 'lastname' :
					esc_html_e( $authorInfo->lastname );
					break;
				case 'fbUrl':
					echo esc_url_raw( $authorInfo->fbUrl );
					break;
				case 'linkedIn':
					echo esc_url_raw( $authorInfo->linkedInUrl );
					break;
				case 'date':
					echo get_the_date();
			}
		}
	}

	add_action( 'admin_init', [ 'Admin_Ui', 'hideTitle' ] );
	add_filter( 'manage_ttp_authors_posts_columns', [ 'Admin_Ui', 'set_custom_ttp_authors_columns' ], 9 );
	add_action( 'manage_ttp_authors_posts_custom_column', [ 'Admin_Ui', 'custom_ttp_authors_column' ], 10, 2 );


}
