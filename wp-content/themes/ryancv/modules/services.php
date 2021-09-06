<?php
	$title = get_sub_field( 'title' );
	$services = get_sub_field( 'items' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Services
-->
<div class="content services">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<?php if ( $services ) : ?>
	<!-- content -->
	<div class="row service-items border-line-v">

		<?php foreach ( $services as $item ) { ?>
		<!-- service item -->
		<div class="col col-d-6 col-t-6 col-m-12 border-line-h">
			<div class="service-item">
				<?php if( $item['icon'] != 'ion-none' && $item['icon'] ) : ?>
					<div class="icon"><span class="ion <?php echo esc_attr( $item['icon'] ); ?>"></span></div>
				<?php endif; ?>
				<?php if( $item['name'] ) : ?>
					<div class="name"><?php echo esc_html( $item['name'] ); ?></div>
				<?php endif; ?>
				<?php if( $item['text'] ) : ?>
					<p><?php echo wp_kses_post( $item['text'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php } ?>
	</div>
	
	<div class="clear"></div>

	<?php endif; ?>

</div>