<?php
	$title = get_sub_field( 'title' );
	$facts = get_sub_field( 'items' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Fun Fact
-->
<div class="content fuct">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<?php if ( $facts ) : ?>
	<!-- content -->
	<div class="row fuct-items">

		<?php foreach ( $facts as $item ) { ?>
		<!-- fuct item -->
		<div class="col col-d-3 col-t-3 col-m-6 border-line-v">
			<div class="fuct-item">
				<?php if ( $item['icon'] != 'ion-none' && $item['icon'] ) : ?>
					<div class="icon"><span class="ion <?php echo esc_attr( $item['icon'] ); ?>"></span></div>
				<?php endif; ?>
				<?php if ( $item['name'] ) : ?>
					<div class="name"><?php echo esc_html( $item['name'] ); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php } ?>

		<div class="clear"></div>
	</div>
	<?php endif; ?>

</div>