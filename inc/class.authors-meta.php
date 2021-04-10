<?php

/**
 * Class Authors_Meta
 * Add meta fields for 'authors' post type
 */

abstract class Authors_Meta {

	/**
	 * Set up and add the meta box.
	 */
	public static function add() {
		add_meta_box(
			'author_info',          // Unique ID
			'Authors info', // Box title
			[ self::class, 'html' ],   // Content callback, must be of type callable
			'authors'                  // Post type
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
	}


	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post Post object.
	 */
	public static function html( $post ) {
		$author_name         = get_post_meta( $post->ID, '_author_name_meta_key', true );
		$author_lastname     = get_post_meta( $post->ID, '_author_lastname_meta_key', true );
		$author_bio          = get_post_meta( $post->ID, '_author_bio_meta_key', true );
		$author_fb_url       = get_post_meta( $post->ID, '_author_fb_meta_key', true );
		$author_linkedin_url = get_post_meta( $post->ID, '_author_linkedin_meta_key', true );
		?>

        <div class="author-manager-class">
            <label for="author_name">First Name</label>
            <input type="text" name="author_name" id="author_name"
                   value="<?php echo $author_name ? $author_name : '' ?>"><br>

            <label for="author_lastname">Last Name</label>
            <input type="text" name="author_lastname" id="author_lastname"
                   value="<?php echo $author_lastname ? $author_lastname : '' ?>">

            <label for="author_bio">Biography</label>
            <textarea name="author_bio" id="author_bio" cols="30"
                      rows="10"><?php echo $author_bio ? $author_bio : '' ?></textarea>

            <label for="author_fb_url">Facebook URL</label>
            <input type="text" name="author_fb_url" id="author_fb_url"
                   value="<?php echo $author_fb_url ? $author_fb_url : '' ?>">

            <label for="author_linkedin_url">Facebook URL</label>
            <input type="text" name="author_linkedin_url" id="author_linkedin_url"
                   value="<?php echo $author_linkedin_url ? $author_linkedin_url : '' ?>">
        </div>
		<?php
	}
}

add_action( 'add_meta_boxes', [ 'Authors_Meta', 'add' ] );
add_action( 'save_post', [ 'Authors_Meta', 'save' ] );
