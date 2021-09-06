<?php
	$title = get_sub_field( 'title' );
	$filters = get_sub_field( 'filters' );
	$portfolio = get_sub_field( 'items' );
	$portfolio_categories = ryancv_get_categories( 'portfolio_categories' );
	$section_id = get_sub_field( 'section_id' );
	$portfolio_single = get_field( 'portfolio_single', 'options' );
	$portfolio_qv = get_field( 'portfolio_qv', 'option' );
?>

<!--
	Works
-->
<div class="content works">

	
	<!-- title -->
	<div class="title <?php if ( ! $title ) : ?>no-title<?php endif; ?>"><?php if ( $title ) : ?><?php echo esc_html( $title ); ?><?php endif; ?></div>

	<?php if ( $filters == '1' && $portfolio_categories ) : ?>
		<!-- filters -->
		<div class="filter-menu filter-button-group">
			<div class="f_btn active">
				<label><input type="radio" name="fl_radio" value=".grid-item" /><?php echo esc_html__( 'All', 'ryancv' ); ?></label>
			</div>
			<?php foreach ( $portfolio_categories as $cat ) { ?>
			<div class="f_btn">
				<label><input type="radio" name="fl_radio" value=".f-<?php echo esc_attr( $cat->slug ); ?>" /><?php echo esc_html( $cat->name ); ?></label>
			</div>
			<?php } ?>
		</div>
	<?php endif; ?>

	<?php if ( $portfolio ) : ?>
	<!-- content -->
	<div class="row grid-items border-line-v">

		<?php foreach ( $portfolio as $row ) { ?>
		<?php
			/*get categories*/
			$current_categories = get_the_terms( $row['post']->ID, 'portfolio_categories' );
			$categories_string = '';
			$categories_slugs_string = '';
			if ( $current_categories && ! is_wp_error( $current_categories ) ) {
				$arr_keys = array_keys( $current_categories );
				$last_key = end( $arr_keys );
				foreach ( $current_categories as $key => $value ) {
					if ( $key == $last_key ) {
						$categories_string .= $value->name . ' ';
					} else {
						$categories_string .= $value->name . ', ';
					}
					$categories_slugs_string .= 'f-' . $value->slug . ' ';
				}
			}
			/*get content*/
			$title = get_the_title( $row['post']->ID );
			$content = apply_filters( 'the_content', get_post_field( 'post_content', $row['post']->ID ) );

			/*get portfolio type*/
			$type = get_field( 'portfolio_type', $row['post']->ID );
			$popup_url = get_the_post_thumbnail_url( $row['post']->ID, 'full' );
			$popup_class = 'has-popup-image';
			$preview_icon = 'ion-image';
			$btn_url = get_field( 'button_url', $row['post']->ID );
			$images = false;
			$popup_link_target = false;

			if ( $type == 2 ) {
				$popup_url = get_field( 'music_url', $row['post']->ID );
				$popup_class = 'has-popup-music';
				$preview_icon = 'ion-music-note';
			} elseif ( $type == 3 ) {
				$popup_url = get_field( 'video_url', $row['post']->ID );
				$popup_class = 'has-popup-video';
				$preview_icon = 'ion-videocamera';
			} elseif ( $type == 4 ) {
				$popup_url = '#popup-' . $row['post']->ID;
				$popup_class = 'has-popup-media';
				$preview_icon = 'ion-search';
			} elseif ( $type == 5 ) {
				$popup_url = '#gallery-' . $row['post']->ID;
				$popup_class = 'has-popup-gallery';
				$preview_icon = 'ion-images';
				$images = get_field( 'gallery', $row['post']->ID );
			} elseif ( $type == 6 ) {
				$popup_url = get_field( 'link_url', $row['post']->ID );
				$popup_link_target = true;
				$popup_class = 'has-popup-link';
				$preview_icon = 'ion-link';
			} else { }
		?>
		<!-- work item -->
		<div class="col col-d-6 col-t-6 col-m-12 border-line-h grid-item <?php echo esc_attr( $categories_slugs_string ); ?>">
			<div class="box-item">
				<div class="image">
					<?php if ( $portfolio_qv ) : ?>
						<?php if ( $portfolio_single ) : ?>
							<a>
								<?php if ( has_post_thumbnail( $row['post']->ID ) ) : 
									echo get_the_post_thumbnail( $row['post']->ID, 'ryancv_600xauto' );
								endif; ?>
								<span class="info">
									<span class="ion"></span>
								</span>
							</a>
						<?php else : ?>
							<a href="<?php echo esc_url( get_the_permalink( $row['post']->ID ) ); ?>">
								<?php if ( has_post_thumbnail( $row['post']->ID ) ) : 
									echo get_the_post_thumbnail( $row['post']->ID, 'ryancv_600xauto' );
								endif; ?>
								<span class="info">
									<span class="ion ion-ios-book-outline"></span>
								</span>
							</a>
						<?php endif; ?>
					<?php else : ?>
						<a href="<?php echo esc_url( $popup_url ); ?>" class="<?php echo esc_attr( $popup_class ); ?>"<?php if ( $popup_link_target ) : ?> target="_blank"<?php endif; ?>>
							<?php if ( has_post_thumbnail( $row['post']->ID ) ) : 
								echo get_the_post_thumbnail( $row['post']->ID, 'ryancv_600xauto' );
							endif; ?>
							<span class="info">
								<span class="ion <?php echo esc_attr( $preview_icon ); ?>"></span>
							</span>
						</a>
						<?php if( $images ) : ?>
							<div id="gallery-<?php echo esc_attr( $row['post']->ID ); ?>" class="mfp-hide">
								<?php foreach( $images as $image ): ?>
								<?php $gallery_img_src = wp_get_attachment_image_src( $image['ID'], 'full' ); ?>
								<a href="<?php echo esc_url( $gallery_img_src[0] ); ?>"></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="desc">
					<?php if ( $portfolio_single ) : ?>
						<?php if ( $portfolio_qv ) : ?>
							<a class="name"><?php echo esc_html( $title ); ?></a>
						<?php else : ?>
							<a href="<?php echo esc_url( $popup_url ); ?>" class="name <?php echo esc_attr( $popup_class ); ?>"><?php echo esc_html( $title ); ?></a>
						<?php endif; ?>	
					<?php else : ?>
						<a href="<?php echo esc_url( get_the_permalink( $row['post']->ID ) ); ?>" class="name"><?php echo esc_html( $title ); ?></a>
					<?php endif; ?>

					<?php if ( $categories_string ) : ?>
						<div class="category"><?php echo esc_html( $categories_string ); ?></div>
					<?php endif; ?>
				</div>

				<?php if ( $type == 4 ) : ?>
				<div id="popup-<?php echo esc_attr( $row['post']->ID ); ?>" class="popup-box mfp-fade mfp-hide">
					<div class="content">
						<div class="image">
							<?php if ( has_post_thumbnail( $row['post']->ID ) ) : 
								echo get_the_post_thumbnail( $row['post']->ID, 'ryancv_720x478' );
							endif; ?>
						</div>
						<div class="desc">
							<div class="post-box">
								<h2 class="h-title"><?php echo esc_html( $title ); ?></h2>
								<?php if ( $categories_string ) : ?>						
								<div class="blog-detail"><?php echo esc_html( $categories_string ); ?></div>
								<?php endif; ?>
								<div class="blog-content">
									<?php echo $content; ?>
								</div>
								<?php if ( $btn_url ) : ?>
								<a href="<?php echo esc_url( $btn_url ); ?>" class="button">
									<span class="text"><?php echo esc_html__( 'View Project', 'ryancv' ); ?></span>
									<span class="arrow"></span>
								</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php } ?>

		<div class="clear"></div>
	</div>
	<?php endif; ?>

</div>