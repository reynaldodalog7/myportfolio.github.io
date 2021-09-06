<?php
	$title = get_sub_field( 'title' );
	$contact_form = get_sub_field( 'form' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Contact Form
-->
<div class="content contacts">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<?php if ( $contact_form ) : ?>
	<!-- content -->
	<div class="row">
		<div class="col col-d-12 col-t-12 col-m-12 border-line-v">
			<div class="contact_form">
				<?php echo the_sub_field( 'form' ); ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endif; ?>

</div>