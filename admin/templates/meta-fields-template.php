<?php
/**
 * Html for rendering meta boxes in admin new post
 */

// Getting values from the db by means of the included public class
global $post;
require_once plugin_dir_path( __FILE__ ) . '../../inc/class.meta-values.php';
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

		// Drop down menu with WP users
		$users = get_users();

		foreach ( $users as $user ): ?>
			<option value="<?php echo esc_attr( $user->ID ) ?>"
				<?php echo $authorInfo->linkedUser == $user->ID ? 'selected' : '' ?>>
				<?php echo esc_attr( $user->user_login ) ?></option>
		<?php endforeach; ?>

	</select>
</div>
