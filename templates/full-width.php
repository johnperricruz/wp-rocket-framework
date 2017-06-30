<?php
/**
 * Template Name: Full-width, no sidebar Page Template
 *
 */
get_header(); ?>
	<div id="primary" class="full-width site-content">
		<div class="container-fluid">
			<div class="row" role="main">
				<div class="col-md-12">
					<?php 
						while (have_posts()){ 
							the_post(); 
							get_template_part( 'content', 'page' ); 
						} 
					?>					
				</div><!-- .col-md-12 -->
			</div><!--.row -->
		</div><!-- .container-fluid -->
	</div><!-- .primary -->
<?php get_footer(); ?>