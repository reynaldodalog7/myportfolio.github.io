<?php
/**
 * Template Name: Layout builder
 *
 * @package ryancv
*/

get_header(); 
?>

<?php
	$onepage = get_field( 'onepage', 'option' );
	$sticky_menu = get_field( 'sticky_menu', 'options' );
	$simple_vcard = get_field( 'simple_vcard', 'options' );

	if ( $onepage && $sticky_menu ) {
		$menu_locations = get_nav_menu_locations();
		$menu_primary = $menu_locations['primary'];
		$frontpage_id = get_option( 'page_on_front' );
	}
?>

<?php if ( $onepage && $sticky_menu && !$simple_vcard && $menu_locations && $menu_primary && is_front_page() ) : ?>
	<?php
		$menu = wp_get_nav_menu_object( $menu_primary );
		$menu_items = wp_get_nav_menu_items( $menu->term_id );

		$page_ids = array();

		foreach ($menu_items as $menu_item) {
			$page_template = get_page_template_slug( $menu_item->object_id );
			if ( $menu_item->object == 'page' && $page_template != 'template-blog.php' ) {
				$page_ids[] = $menu_item->object_id;
			}
		}

		$args = array(
			'post_type' => 'page',
			'post__in' => $page_ids,
			'posts_per_page' => count( $page_ids ),
			'orderby' => 'post__in'
		);

		$custom_query = new WP_Query( $args );
		
		if ( $custom_query->have_posts() ) {
			while ( $custom_query->have_posts() ) { $custom_query->the_post();
				global $post;				
				
				$tpl_url = get_page_template_slug( $post->ID );

				if ( $tpl_url ) {
					$tpl_slug = explode( '.', $tpl_url ); ?>

					<div class="card-inner<?php if ( $frontpage_id == $post->ID ) : ?> animated active<?php endif; ?>" id="card-<?php echo esc_attr( $post->post_name ); ?>">
						<div class="card-wrap">	
							<?php echo get_template_part( 'layout-builder' ); ?>
						</div>
					</div>

				<?php } else { ?>
					
					<div class="card-inner<?php if ( $frontpage_id == $post->ID ) : ?> animated active<?php endif; ?>" id="card-<?php echo esc_attr( $post->post_name ); ?>">
						<div class="card-wrap">
							
							<!--
								Page
							-->
							<div class="content blog-page">
							

							<?php
								get_template_part( 'template-parts/content', 'page' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>

							</div>
							
						</div>
					</div>

				<?php }
			};
		}
		
	?>
<?php else : ?>
<div class="card-inner animated active" id="about-card">
	<div class="card-wrap">
		<?php echo get_template_part( 'layout-builder' ); ?>
	</div>
</div>
<?php endif; ?>
	
<?php
get_footer();