<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ryancv
 */

get_header();
?>

<div class="card-inner animated active" id="card-portfolio-archive">
	<div class="card-wrap">
	
		<!--
			Works
		-->
		<div class="content works">

			<?php if ( have_posts() ) : ?>
			<!-- title -->
			<h1 class="title"><?php echo esc_html( get_the_archive_title() ); ?></h1>
			
			<!-- content -->
			<div class="row grid-items border-line-v">

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