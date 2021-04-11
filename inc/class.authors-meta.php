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
	 *
	 * @param \WP_Post $post Post object.
	 */
	public static function html( $post ) {
		/**
		 * Getting values from the db by means of the included public class
		 */
		require_once plugin_dir_path( __FILE__ ) . 'class.meta-values.php';
		$authorInfo = new Meta_Values( $post->ID );
		?>

        <div class="author-manager-class">
            <label for="author_name">First Name</label>
            <input type="text" name="author_name" id="author_name"
                   value="<?php echo $authorInfo->firstname ? $authorInfo->firstname : '' ?>"><br>

            <label for="author_lastname">Last Name</label>
            <input type="text" name="author_lastname" id="author_lastname"
                   value="<?php echo $authorInfo->lastname ? $authorInfo->lastname : '' ?>">

            <label for="author_bio">Biography</label>
            <textarea name="author_bio" id="author_bio" cols="30"
                      rows="10"><?php echo $authorInfo->bio ? $authorInfo->bio : '' ?></textarea>

            <label for="author_fb_url">Facebook URL</label>
            <input type="text" name="author_fb_url" id="author_fb_url"
                   value="<?php echo $authorInfo->fbUrl ? $authorInfo->fbUrl : '' ?>">

            <label for="author_linkedin_url">LinkedIn URL</label>
            <input type="text" name="author_linkedin_url" id="author_linkedin_url"
                   value="<?php echo $authorInfo->linkedInUrl ? $authorInfo->linkedInUrl : '' ?>">

            <label for="linked_user">Link author to user </label>
            <select name="linked_user" id="linked_user">

				<?php

				$users = get_users();

				foreach ( $users as $user ): ?>
                    <option value="<?php echo esc_attr( $user->ID ) ?>"
						<?php echo $authorInfo->linkedUser == $user->ID ? 'selected' : '' ?>>
						<?php echo esc_attr( $user->user_login ) ?></option>

				<?php endforeach; ?>

            </select>

            <input type="button" name="mytheme_gallery" class="button insert-media add_media"
                   data-editor="content" title="Add Media" value="Add gallery">
        </div>
		<?php
	}
}

add_action( 'add_meta_boxes', [ 'Authors_Meta', 'add' ] );
add_action( 'save_post', [ 'Authors_Meta', 'save' ] );
