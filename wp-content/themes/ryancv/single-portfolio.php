<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ryancv
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<!--
		Card - Portfolio
	-->
	<div class="card-inner blog blog-post animated active" id="card-portfolio-single">
		<div class="card-wrap">

			<!--
				Blog Single
			-->
			<div class="content blog-single">

				<?php get_template_part( 'template-parts/content', 'single-portfolio' ); ?>

				<?php
					the_post_navigation( array(
						'screen_reader_text' => ' ',
						'next_text' => '<span class="post-nav-prev post-nav-text">' . esc_html__( 'Next', 'ryancv' ) . '</span>',
						'prev_text' => '<span class="post-nav-next post-nav-text">' . esc_html__( 'Prev', 'ryancv' ) . '</span>'
					) );
				
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			</div>

		</div>
	</div>
	
	<?php endwhile; ?>

<?php
get_footer();