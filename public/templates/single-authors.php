<?php
/**
 * single-authors template overrides default single.php in theme folder
 */
/**
 * Getting values from the db by means of the included public class
 */
require_once plugin_dir_path( __FILE__ ) . '../../inc/class.meta-values.php';
$authorInfo = new Meta_Values( get_the_ID() );


/*echo $authorInfo->firstname ? '<p>' . $authorInfo->firstname . '</p>' : '';
echo $authorInfo->lastname ? '<p>' . $authorInfo->lastname . '</p>' : '';
echo $authorInfo->bio ? '<p>' . $authorInfo->bio . '</p>' : '';
echo $authorInfo->fbUrl ? '<p>' . $authorInfo->fbUrl . '</p>' : '';
echo $authorInfo->linkedInUrl ? '<p>' . $authorInfo->linkedInUrl . '</p>' : '';*/


get_header(); ?>

    <main class="author-bio-section">
        <h1>Author info</h1>

		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>

                <figure class="author-image">
					<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); // Featured image ?>
                </figure>
                <section class="author-info">
                    <h3><?php echo $authorInfo->firstname . ' ' . $authorInfo->lastname ?></h3>
                    <p><?php echo $authorInfo->bio ?></p>
                    <div class="author-gallery">
                        <h4>Author's Gallery</h4>
						<?php the_content(); // Gallery ?>
                    </div>
                </section>
                <div class="clearfix"></div>

                <h3>Linked User</h3>
                <h4>This author is linked to <?php echo get_userdata( $authorInfo->linkedUser )->user_nicename ?></h4>

				<?php
				// Posts from the WP User the author is linked to

				if ( $authorInfo->linkedUser ) {
					$query = new WP_Query( [
						'post_type'      => 'post',
						'posts_per_page' => 10,
						'author'         => $authorInfo->linkedUser
					] );

					if ( $query->have_posts() ) {
						echo 'Posts by ' . get_userdata( $authorInfo->linkedUser )->user_nicename;
						while ( $query->have_posts() ) {
							$query->the_post();

							echo '<h4>' . get_the_title() . '</h4>';
							if(get_the_content()!=null){
								echo '<p>' . wp_trim_words( get_the_content(), 10 ) . '</p>';
							}
							echo '<small>'.get_the_date().'</small>';

						}
					} else {
						echo 'This user does not have any posts yet';
					}
				}

				?>
			<?php }
		}
		?>
    </main>

<?php
get_footer();
