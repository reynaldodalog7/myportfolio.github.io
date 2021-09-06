<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ryancv
 */

?>

<?php
	$blog_featured_img = get_field( 'blog_featured_img', 'option' );
	//get blog post subtitle
	$blog_post_subtitle = get_field( 'blog_post_subtitle', 'option' );
	if( ! $blog_post_subtitle ) {
		$blog_post_subtitle = esc_html__( 'Blog Post', 'ryancv' );
	}
 ?>

<!-- title -->
<h1 class="title"><?php echo esc_html( $blog_post_subtitle ); ?></h1>

<!-- content -->
<div class="row border-line-v">
	<div class="col col-m-12 col-t-12 col-d-12">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-box single-post-text">
				
				<h1 class="h-title"><?php the_title(); ?></h1>
				
				<!-- blog detail -->					
				<div class="blog-detail">
					<span class="date"><?php the_date(); ?></span>
					<?php ryancv_entry_header(); ?>
				</div>
				
				<?php if ( has_post_thumbnail() && ! $blog_featured_img ) : ?>
				<!-- blog image -->
				<div class="blog-image">
					<?php
						the_post_thumbnail( 'full', array(
							'alt' => the_title_attribute( array(
								'echo' => false,
							)),
						) );
					?>
				</div>  
				<?php endif; ?>
				
				<!-- blog content -->
				<div class="blog-content">
					<?php 
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ryancv' ),
							'after'  => '</div>',
						) );
					?>
				</div>

				<div class="post-text-bottom">	
					<?php ryancv_entry_footer(); ?>
				</div>
			</div>
		</div><!-- #post-<?php the_ID(); ?> -->
	</div>
</div>