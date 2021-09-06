<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ryancv
 */

?>

<?php

$blog_categories = get_field( 'blog_categories', 'option' );
$blog_excerpt = get_field( 'blog_excerpt', 'option' );

?>

<!-- blog item -->
<div class="col col-d-6 col-t-6 col-m-12">
	<div class="box-item">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="image">
				<?php ryancv_post_thumbnail(); ?>
			</div>
			<div class="desc">
				<?php if ( 'post' === get_post_type() ) : ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<span class="date">
							<?php echo esc_html( get_the_date() ); ?>
						</span>
					</a>
				<?php endif; ?>

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="name"><?php the_title(); ?></a>
				
				<?php if( $blog_categories ) : ?>
				<div class="category">
					<?php
					$categories_list = get_the_category();
					if ( $categories_list ) {
						foreach ( $categories_list as $category ) {
							echo '<span class="category-name">' . esc_html( $category->cat_name ) . '</span>';
						}
					}
					?>
				</div>
				<?php endif; ?>

				<?php if ( ! $blog_excerpt ) : ?>
				<div class="text">
					<?php the_excerpt(); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>