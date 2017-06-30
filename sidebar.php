<?php
/**
 * The sidebar containing the main widget area
 *
 */
?>
<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'primary-sidebar' ); ?>
	</div><!-- #secondary -->
<?php endif; ?>