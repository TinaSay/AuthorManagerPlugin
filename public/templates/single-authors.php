<?php
/**
 * single-authors template overrides default single.php in theme folder
 */

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		/**
		 * Getting values from the db by means of the included public class
		 */
		require_once plugin_dir_path( __FILE__ ) . '../../inc/class.meta-values.php';
		$authorInfo = new Meta_Values( get_the_ID() );

		echo $authorInfo->firstname ? '<p>' . $authorInfo->firstname . '</p>' : '';
		echo $authorInfo->lastname ? '<p>' . $authorInfo->lastname . '</p>' : '';
		echo $authorInfo->bio ? '<p>' . $authorInfo->bio . '</p>' : '';
		echo $authorInfo->fbUrl ? '<p>' . $authorInfo->fbUrl . '</p>' : '';
		echo $authorInfo->linkedInUrl ? '<p>' . $authorInfo->linkedInUrl . '</p>' : '';

		echo get_the_post_thumbnail( get_the_ID(), 'thumb' ); // Featured image

		the_content(); // Gallery

		// Posts from the WP User the author is linked to

		if ( $authorInfo->linkedUser ) {
			$query = new WP_Query( [
				'post_type'      => 'post',
				'posts_per_page' => 10,
				'author'         => $authorInfo->linkedUser
			] );

			if ( $query->have_posts() ) {
				echo 'This author is linked to ' . get_userdata( $authorInfo->linkedUser )->user_nicename . '<br>';
				while ( $query->have_posts() ) {
					$query->the_post();

					echo '<h4>' . get_the_title() . '</h4>';

				}
			}
		}

		?>
	<?php }
}

get_footer();
