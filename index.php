<?php get_header(); ?>
	<div id="primary" class="index-page site-content">
		<header class="innerpage-header p-5">
			<h1 class="text-center innerpage-title">Posts</h1>
		</header>
		<div class="container">
			<div class="row" role="main">
				<div class="col-md-8">
					<?php
					if (have_posts()){ 
						while(have_posts()){ 
								the_post();
								?> 
									<div class="index-lists">
										<div class="row">
											<div class="col-md-4">
												<?php if(has_post_thumbnail()){?>
													<?php echo '<img title="'.get_the_title().'" alt="'.get_the_title().'" class="img-fluid wp-post-image" src="'.wp_get_attachment_url( get_post_thumbnail_id() ).'" width="100%" height="auto" />';?>
												<?php }else{
													echo '<img class="img-fluid" src="//placehold.it/300x300" draggable="false" alt="No Image" title="No Image" />';
												} ?>
											</div>
											<div class="col-md-8">
												<h2><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
												<span class="date-posted"><i aria-hidden="true" class="fa fa-clock"></i>&nbsp;<?php echo get_the_date(); ?></span>
												<br/>
												<p><?php echo get_the_excerpt(); ?></p>
												<div class="archieve-action">
													<a class="btn btn-primary" href="<?php echo get_the_permalink(); ?>"><span class="glyphicon glyphicon-search"></span> Read more</a>
												</div>
											</div>
										</div>
									</div>
								<?php
							} 
							wp_reset_query();
							echo '<div class="pagination">'.rocketPage().'</div>';
						?>
						<?php }else{ // end of the condition. ?>
							<h3>No posts to show.</h3>
						<?php } // end of the else. ?>	
				</div><!-- .col-md-8 -->
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div><!-- .col-md-4 -->
			</div><!--.row -->
		</div><!-- .container-fluid -->
	</div><!-- .primary -->
<?php get_footer(); ?>