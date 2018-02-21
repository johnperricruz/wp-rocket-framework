<?php
/**
 * Template Name: Full-width, no sidebar Page Template (Bootstrap 12 Column Grid)
 *
 */
get_header(); ?>
	<div id="primary" class="full-width site-content">
		<header class="innerpage-header p-5">
			<h1 class="text-center innerpage-title"><?php the_title(); ?></h1>
		</header>
		<div class="container">
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