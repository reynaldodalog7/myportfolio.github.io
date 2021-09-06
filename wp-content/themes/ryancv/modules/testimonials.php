<?php
	$title = get_sub_field( 'title' );
	$testimonials = get_sub_field( 'items' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Clients
-->

<div class="content testimonials">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<!-- content -->
	<div class="row testimonial-items">

		<div class="col col-d-12 col-t-12 col-m-12 border-line-v">
			<div class="revs-carousel">
				<div class="owl-carousel">
					<?php foreach ( $testimonials as $item ) { ?>
					<div class="item">
						<div class="revs-item">
							<?php if( $item['text'] ) : ?>
							<div class="text">
								<?php echo esc_html( $item['text'] ); ?>
							</div>
							<?php endif; ?>
							<div class="user">
								<?php
									$img = $item['img'];
									if( $img ) : 
								?>
								<div class="img"><img src="<?php echo esc_url( $img['sizes']['ryancv_92x92'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" /></div>
								<?php endif; ?>
								<div class="info">
									<?php if( $item['name'] ) : ?>
									<div class="name"><?php echo esc_html( $item['name'] ); ?></div>
									<?php endif; ?>
									<?php if( $item['subname'] ) : ?>
									<div class="company"><?php echo esc_html( $item['subname'] ); ?></div>
									<?php endif; ?>
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="clear"></div>
	</div>

</div>