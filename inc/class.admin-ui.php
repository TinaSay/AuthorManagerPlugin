<?php
/**
 * Class takes care of slight admin panel UI changes
 */
if ( ! class_exists( 'Admin_Ui' ) ) {

	class Admin_Ui {
		/**
		 * Hide title field from standard admin view
		 */
		public static function hideTitle() {
			remove_post_type_support( 'authors', 'title' );
		}

		/**
		 * Filter posts to make them display author names as titles
		 */
		public static function postTitleAsAuthorName( $title, $post_id ) {
			if ( is_admin() && get_post_type() == 'authors' ) {
				$title = get_post_meta( $post_id, '_author_name_meta_key', true );
			}

			return $title;
		}

		/**
		 * Rename Add Media button to make it more clear
		 */
		public static function renameMediaButton( $translation, $text ) {
			if ( is_admin() && 'Add Media' === $text && get_post_type() == 'authors' ) {
				return 'Add Image Gallery';
			}

			return $translation;
		}
	}

	add_action( 'admin_init', [ 'Admin_Ui', 'hideTitle' ] );
	add_filter( 'the_title', [ 'Admin_Ui', 'postTitleAsAuthorName' ], 10, 2 );
	add_filter( 'gettext', [ 'Admin_Ui', 'renameMediaButton' ], 10, 2 );
}
