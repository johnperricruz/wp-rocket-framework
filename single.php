<?php
/**
 * The template for displaying all post page
 *
 */
get_header(); ?>
	<div id="primary" class="post site-content">
		<div class="container">
			<div class="row" role="main">
				<div class="col-md-8">
				<?php 
					while (have_posts()){ 
						the_post(); 
						get_template_part( 'content', 'single' ); 
					} 
				?>
				</div><!-- .col-md-8 -->
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div><!-- .col-md-4 -->
			</div><!--.row -->
		</div><!-- .container--> 
	</div><!-- .primary -->
<?php get_footer(); ?>