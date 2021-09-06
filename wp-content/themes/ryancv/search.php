<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ryancv
 */

get_header();
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
			<?php if ( have_posts() ) : ?>
				<!-- title -->
				<h1 class="title">
					<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results: %s', 'ryancv' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>

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
						get_template_part( 'template-parts/content-search', get_post_type() );

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