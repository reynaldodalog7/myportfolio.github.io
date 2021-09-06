<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ryancv
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- title -->
	<h1 class="title"><?php the_title(); ?></h1>

	<!-- content -->
	<div class="row border-line-v">
		<div class="col col-m-12 col-t-12 col-d-12">
			<div class="post-box single-post-text">
				<div class="blog-content">
					<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ryancv' ),
							'after'  => '</div>',
						) );
					?>
				</div>

				<?php if ( get_edit_post_link() ) : ?>
					<div class="single-post-bottom">
						<?php
						edit_post_link(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Edit <span class="screen-reader-text">%s</span>', 'ryancv' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							),
							'<span class="edit-link">',
							'</span>'
						);
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
</div><!-- #post-<?php the_ID(); ?> -->