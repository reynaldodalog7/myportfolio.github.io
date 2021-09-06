<?php
	$title = get_sub_field( 'title' );
	$pagination = get_sub_field( 'pagination' );
	$more_btn_txt = get_sub_field( 'more_btn_txt' );
	$more_btn_url = get_sub_field( 'more_btn_url' );
	$blog_count = get_sub_field( 'count' );
	$section_id = get_sub_field( 'section_id' );
	$blog_slug = '#' . get_post_field( 'post_name', get_post() );
	$blog_cat = get_sub_field( 'category' );
?>

<?php

if ( $blog_count ) {
	$posts_per_page = $blog_count;
} else {
	$posts_per_page = get_option( 'posts_per_page' );
}

if ( get_query_var( 'paged' ) ) {
    $paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
    $paged = get_query_var( 'page' );
} else {
    $paged = 1;
}

$posts = wp_count_posts( 'post' );
$total_posts = $posts->publish;

$args = array(
	'post_type' => 'post',
	'posts_per_page' => $posts_per_page,
	'paged' => $paged,
	'post_status' => 'publish',
	'order' => 'desc'
);

if ( $blog_cat ) {
	$args['cat'] = $blog_cat;
}

$the_query = new WP_Query( $args );
query_posts( $args );

?>

<!--
	Blog
-->
<div class="content blog">
	<?php if ( $the_query->have_posts() ) : ?>
		<!-- title -->
		<div class="title"><?php echo esc_html( $title ); ?></div>

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

		<?php if ( $pagination == 1) : ?>
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
					'add_fragment' => $blog_slug,
					'screen_reader_text' => esc_html__( ' ', 'ryancv' ),
				) );
			?>
		</div>
		<?php endif; ?>

		<?php if ( $pagination == 2) : ?>
		<div class="bts bts-center">
			<a class="lnk" href="<?php echo esc_url( $more_btn_url ); ?>"><?php echo esc_html( $more_btn_txt ); ?></a>
		</div>
		<?php endif; ?>

	<?php else :
		get_template_part( 'template-parts/content', 'none' );
	endif;

	?>
</div>