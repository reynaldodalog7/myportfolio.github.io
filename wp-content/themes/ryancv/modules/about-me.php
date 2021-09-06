<?php
	$title = get_sub_field( 'title' );
	$description = get_sub_field( 'text' ); 
	$info = get_sub_field( 'info' );
	$section_id = get_sub_field( 'section_id' );
?>

<!-- 
	About 
-->
<div class="content about">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<!-- content -->
	<div class="row">
		<?php
			$col_class = 'col col-d-6 col-t-12 col-m-12';

			if ( ! $info || ! $description ) {
				$col_class = 'col col-d-12 col-t-12 col-m-12';
			}
		?>

		<?php if ( $description ) : ?>
		<div class="<?php echo esc_attr( $col_class );?> border-line-v">
			<div class="text-box">
				<?php echo wp_kses_post( $description ); ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $info ) : ?>
		<div class="<?php echo esc_attr( $col_class );?> border-line-v">
			<div class="info-list">
				<ul>
					<?php foreach ( $info as $item ) { ?>
					<li><strong><?php echo esc_html( $item['label'] ); ?></strong> <?php echo esc_html( $item['value'] ); ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="clear"></div>
	</div>

</div>