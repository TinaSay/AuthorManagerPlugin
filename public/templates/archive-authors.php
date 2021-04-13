<?php

require_once plugin_dir_path( __FILE__ ) . '../../inc/class.meta-values.php';
get_header(); ?>

    <main class="author-bio-section">
        <h1>Authors</h1>
        <section class="linked-user">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();

					$authorInfo = new Meta_Values( get_the_ID() ); // Retrieving values
					$link       =  add_query_arg(
						$authorInfo->firstname,
						$authorInfo->lastname,
						get_the_permalink()
					) ; // Rewriting the permalink

					?>

                    <div class="post-item">
                        <a href="<?php echo esc_url_raw($link) ?>">
                            <h3><?php echo esc_html_e($authorInfo->firstname) . esc_html_e(' ') . esc_html_e($authorInfo->lastname) ?></h3></a>
						<?php
						if ( has_post_thumbnail() ) {
							echo get_the_post_thumbnail( get_the_ID(), 'thumbnail', [ 'class' => 'auth-img' ] );
						} else {
							?>
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . '../img/avatar.jpg' ?>" alt=""
                                 class="auth-img">
						<?php
						}
						echo esc_textarea(wp_trim_words($authorInfo->bio, 55 ));
						?>
                        <a href="<?php echo esc_url_raw($link) ?>">
                            <p>See profile</p>
                        </a>

                    </div>
				<?php }

			} ?>

        </section>
    </main>

<?php
get_footer();
