<?php
	$title = get_sub_field( 'title' );
	$map = get_sub_field( 'map' );
	$fields = get_sub_field( 'items' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Conacts Info
-->
<div class="content contacts">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<!-- content -->
	<div class="row">
		<div class="col col-d-12 col-t-12 col-m-12 border-line-v">
			<?php if ( ! empty( $map ) ) : ?>
			<div class="map acf-map">
				<div class="marker" data-lat="<?php echo esc_attr( $map['lat'] ); ?>" data-lng="<?php echo esc_attr( $map['lng'] ); ?>"></div>
			</div>
			<?php endif; ?>

			<?php if ( $fields ) : ?>
			<div class="info-list">
				<ul>
					<?php foreach ( $fields as $item ) { ?>
					<li>
						<strong><?php echo esc_html( $item['label'] ); ?><?php echo esc_html__( ':', 'ryancv' ); ?></strong> 
						<?php echo esc_html( $item['value'] ); ?>
					</li>
					<?php } ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
		<div class="clear"></div>
	</div>

</div>