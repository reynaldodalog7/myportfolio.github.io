<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ryancv
 */

get_header();
?>
	
<!--
	Card - 404
-->
<div class="card-inner p404 animated active" id="card-404">
	<div class="card-wrap">

		<!--
			404
		-->
		<div class="content">
			<!-- title -->
			<h1 class="title"><?php esc_html_e( '404', 'ryancv' ); ?></h1>

			<!-- content -->
			<div class="row border-line-v">

				<div class="col col-m-12 col-t-12 col-d-12">
					<div class="post-box single-post-text">
						<?php $p404_content = get_field( 'p404_content', 'option' ); ?>
						<?php if ( $p404_content ) : ?>
							<?php echo $p404_content; ?>
						<?php else : ?>
							<p><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'ryancv' ); ?></p>
						<?php endif; ?>
					</div>
				</div>

				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
