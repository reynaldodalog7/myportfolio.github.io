<?php
	$title = get_sub_field( 'title' );
	$text = get_sub_field( 'text' );
	$img = get_sub_field( 'img' );
	$name = get_sub_field( 'name' );
	$subname = get_sub_field( 'subname' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Clients
-->

<div class="content quote">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<!-- content -->
	<div class="row">
		<div class="col col-d-12 col-t-12 col-m-12 border-line-v">
			<div class="revs-item">
				<?php if( $text ) : ?>
				<div class="text">
					<?php echo esc_html( $text ); ?>
				</div>
				<?php endif; ?>
				<div class="user">
					<?php if( $img ) : ?>
					<div class="img"><img src="<?php echo esc_url( $img['sizes']['ryancv_92x92'] ); ?>" alt="<?php echo esc_attr( $name ); ?>" /></div>
					<?php endif; ?>
					<div class="info">
						<?php if( $name ) : ?>
						<div class="name"><?php echo esc_html( $name ); ?></div>
						<?php endif; ?>
						<?php if( $subname ) : ?>
						<div class="company"><?php echo esc_html( $subname ); ?></div>
						<?php endif; ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

</div>