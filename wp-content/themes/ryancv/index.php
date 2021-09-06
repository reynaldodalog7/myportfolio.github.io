<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ryancv
 */

get_header();
?>

<?php
	//get blog subtitle
	$blog_subtitle = get_field( 'blog_subtitle', 'option' );
	if( ! $blog_subtitle ) {
		$blog_subtitle = esc_html__( 'Latest Posts', 'ryancv' );
	}
?>

<!--
	Card - Blog
-->
<div class="card-inner blog animated active" id="card-blog-index">
	<div class="card-wrap">

		<!--
			Blog
		-->
		<div class="content blog">
			<?php if ( have_posts() ) : ?>
				<!-- title -->
				<h1 class="title"><?php echo esc_html( $blog_subtitle ); ?></h1>

				<!-- content -->
				<div class="row border-line-v">

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

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