<?php

if ( ! class_exists( 'AuthorsWidget' ) ) {
	class AuthorsWidget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				'ttp_authors_widget', // Base ID
				'Authors Block', // Name
				array( 'description' => __( 'Authors block', 'text_domain' ), ) // Args
			);
		}

		public $args = array(
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
			'before_widget' => '<div class="authors-block">',
			'after_widget'  => '</div></div>'
		);

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $this->args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $this->args['before_title'] . $title . $this->args['after_title'];
			}

			$authorsQuery = new WP_Query( [
				'post_type'      => 'ttp_authors',
				'posts_per_page' => 5,
				'status'         => 'publish'
			] );

			if ( $authorsQuery->have_posts() ) {
				?>

                <div>

					<?php
					while ( $authorsQuery->have_posts() ) {
						$authorsQuery->the_post();
						$authorInfo = new Meta_Values( get_the_ID() );
						?>
                        <div class="post-item">
                            <a href="<?php echo get_permalink() ?>">
                                <h5><?php echo esc_html_e($authorInfo->firstname) . esc_html_e(' ') . esc_html_e($authorInfo->lastname) ?></h5></a>
							<?php
							if ( has_post_thumbnail() ) {
								echo get_the_post_thumbnail( get_the_ID(), 'thumbnail', [ 'class' => 'auth-img' ] );
							} else {
								?>
                                <img src="<?php echo plugin_dir_url( __FILE__ ) . '../img/avatar.jpg' ?>" alt=""
                                     class="auth-img">
								<?php
							}
							echo '<p>'. esc_textarea(wp_trim_words($authorInfo->bio, 20 )).'</p>';
							?>

                        </div>
                        <?php
					} ?>

                </div>
				<?php

			}

			echo $this->args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = __( 'New title', 'text_domain' );
			}
			?>
            <p>
                <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>"/>
            </p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

			return $instance;
		}

	}
}
