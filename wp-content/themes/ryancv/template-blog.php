<?php
/**
 * Template Name: Blog
 *
 * @package ryancv
*/

get_header();
?>

<?php
	$blog_title = single_post_title( '', false );

	wp_reset_postdata();

	$posts_per_page = get_option( 'posts_per_page' );
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	$posts = wp_count_posts( 'post' );
	$total_posts = $posts->publish;

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
		'post_status' => 'publish',
		'order' => 'desc'
	);
	$the_query = new WP_Query( $args );
	query_posts( $args );
?>

<!--
	Card - Blog
-->
<div class="card-inner blog animated active" id="card-blog-archive">
	<div class="card-wrap">

		<!--
			Blog
		-->
		<div class="content blog">
			<?php if ( $the_query->have_posts() ) : ?>
				<!-- title -->
				<div class="title"><?php echo esc_html( $blog_title ); ?></div>

				<!-- content -->
				<div class="row border-line-v">

					<?php
					/* Start the Loop */
					while ( $the_query->have_posts() ) :
						$the_query->the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;
					?>

					<div class="clear"></div>
				</div>

				<div class="pager">
					<?php
						the_posts_pagination( array(
							'show_all'     => false,
							'end_size'     => 1,
							'mid_size'     => 1,
							'prev_next'    => true,
							'prev_text'    => esc_html__( 'Prev', 'ryancv' ),
							'next_text'    => esc_html__( 'Next', 'ryancv' ),
							'add_args'     => false,
							'add_fragment' => '',
							'screen_reader_text' => esc_html__( ' ', 'ryancv' ),
						) );
					?>
				</div>
			<?php else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</div>

	</div>
</div>

<?php
get_footer();