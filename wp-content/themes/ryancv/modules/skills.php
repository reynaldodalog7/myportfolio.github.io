<?php
	$title = get_sub_field( 'title' );
	$skills = get_sub_field( 'items' );
	$section_id = get_sub_field( 'section_id' );
?>

<!--
	Skills
-->
<div class="content skills">

	<?php if ( $title ) : ?>
	<!-- title -->
	<div class="title"><?php echo esc_html( $title ); ?></div>
	<?php endif; ?>

	<?php if ( $skills ) : ?>
	<!-- content -->
	<div class="row">
		<?php 
			$col_count = count( $skills );
			$col_class = 'col col-d-12 col-t-12 col-m-12';

			if( $col_count > 1 ) {
				$col_class = 'col col-d-6 col-t-6 col-m-12';
			}
		?>

		<?php foreach ( $skills as $item ) { ?>
		<!-- skill item -->
		<div class="<?php echo esc_attr( $col_class ); ?> border-line-v">
			<div class="skills-list <?php if ( $item['skills_radio'] ) : echo esc_attr( $item['skills_radio'] ); endif; ?>">
				<div class="skill-title border-line-h">
					<?php if( $item['icon'] != 'ion-none' && $item['icon'] ) : ?>
					<div class="icon"><i class="ion <?php echo esc_attr( $item['icon'] ); ?>"></i></div>
					<?php endif; ?>
					<?php if( $item['title'] ) : ?>
					<div class="name"><?php echo esc_html( $item['title'] ); ?></div>
					<?php endif; ?>
				</div>

				<?php if ( $item['fields'] ) : ?>
				<ul>
					<?php foreach ( $item['fields'] as $field ) { ?>
					<li class="border-line-h"> 
						<div class="name"><?php echo esc_html( $field['name'] ); ?></div>
						<div class="progress <?php if ( $item['skills_radio'] == 'circles' ) : ?>p<?php echo esc_attr( str_replace('%', '', $field['progress'] ) ); ?><?php endif; ?>">
							<div class="percentage" style="width:<?php echo esc_attr( $field['progress'] ); ?>;"></div>
							<?php if ( $item['skills_radio'] == 'circles' ) : ?><span><?php echo esc_attr( $field['progress'] ); ?></span><?php endif; ?>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
		<?php } ?>

		<div class="clear"></div>
	</div>
	<?php endif; ?>

</div>