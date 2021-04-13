<?php
/**
 * single-authors template overrides default single.php in theme folder
 */
/**
 * Getting values from the db by means of the included public class
 */
require_once plugin_dir_path( __FILE__ ) . '../../inc/class.meta-values.php';
$authorInfo = new Meta_Values( get_the_ID() );

$linkedUserNick = get_userdata( $authorInfo->linkedUser )->user_nicename;

get_header(); ?>

    <main class="author-bio-section">
        <h1>Author info</h1>

		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>

                <figure class="author-image">
					<?php
					if ( has_post_thumbnail() ) {
						echo get_the_post_thumbnail( get_the_ID(), 'large' ); // Featured image
					} else { ?>
                        <img src="<?php echo plugin_dir_url( __FILE__ ) . '../img/avatar.jpg' ?>" alt="">
					<?php } ?>

                    <div class="soc-links">
						<?php if ( $authorInfo->fbUrl ): ?>
                            <a href="<?php echo $authorInfo->fbUrl ?>" target="_blank">
                                <img src="<?php echo plugin_dir_url( __FILE__ ) . '../img/facebook.png' ?>"
                                     alt="fb-link">
                            </a>
						<?php endif; ?>
						<?php if ( $authorInfo->linkedInUrl ): ?>
                            <a href="<?php echo $authorInfo->linkedInUrl ?>" target="_blank">
                                <img src="<?php echo plugin_dir_url( __FILE__ ) . '../img/linkedin.png' ?>"
                                     alt="linkedIn-link">
                            </a>
						<?php endif; ?>
                    </div>
                </figure>
                <section class="author-info">
                    <h3><?php echo $authorInfo->firstname . ' ' . $authorInfo->lastname ?></h3>
                    <p><?php echo $authorInfo->bio ?></p>
                    <div class="author-gallery">
						<?php
						if ( get_the_content() ):
							?>
                            <h4>Author's Gallery</h4>
							<?php the_content(); // Gallery
						endif;
						?>
                    </div>
                </section>
                <div class="clearfix"></div>

                <h1>Related User: <?php echo $linkedUserNick ?></h1>
                <section class="linked-user">

					<?php
					// Posts from the WP User the author is linked to

					if ( $authorInfo->linkedUser ) {
						$query = new WP_Query( [
							'post_type'      => 'post',
							'posts_per_page' => 10,
							'author'         => $authorInfo->linkedUser
						] );

						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();

								echo '<div class="post-item">'; ?>
                                <h4><a href="<?php echo get_the_permalink() ?>"><?php echo get_the_title() ?></a></h4>
								<?php

								echo get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
								if ( get_the_content() != null ) {
									echo wp_trim_words( get_the_content(), 55 );
								}
								echo '<p class="post-dates">'
								     . get_the_date() . ' | ' . $linkedUserNick . ' | ' . get_the_category_list( ',' ) . '</p>';
								echo '</div>';

							}
						} else {
							echo 'This user does not have any posts yet';
						}
					}

					?>
                </section>
			<?php }
		}
		?>
    </main>

<?php
get_footer();
