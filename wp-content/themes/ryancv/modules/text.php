<?php
	$title = get_sub_field( 'title' );
	$description = get_sub_field( 'text' );
	$section_id = get_sub_field( 'section_id' );
?>

<!-- 
	Custom Text 
-->
<div class="content custom-text">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<!-- content -->
	<div class="row border-line-v">
		<div class="col col-m-12 col-t-12 col-d-12">
			<div class="post-box single-post-text">
				<?php if ( $description ) : ?>
				<div class="blog-content">
					<?php the_sub_field( 'text' ); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

</div>