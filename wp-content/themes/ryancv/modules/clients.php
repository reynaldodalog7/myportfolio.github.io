<?php
	$title = get_sub_field( 'title' );
	$clients = get_sub_field( 'items' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Clients
-->
<div class="content clients">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<!-- content -->
	<div class="row client-items">

		<?php foreach ( $clients as $item ) { ?>
		<!-- client item -->
		<div class="col col-d-3 col-t-3 col-m-6 border-line-v">
			<div class="client-item">
				<div class="image">
					<a target="_blank" href="<?php echo esc_url( $item['url'] ); ?>">
						<?php
							$img = $item['img'];
							if( $img ) : 
						?>
						<img src="<?php echo esc_url( $img['sizes']['ryancv_92x92'] ); ?>" alt="<?php echo esc_attr__( 'Client', 'ryancv' ); ?>" />
						<?php endif; ?>
					</a>
				</div>
			</div>
		</div>
		<?php } ?>

		<div class="clear"></div>
	</div>

</div>