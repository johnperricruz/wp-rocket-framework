<?php
/**
 * The template for displaying Archive pages
 *
 */
get_header(); ?>
	<div id="primary" class="archive site-content">
		<header class="innerpage-header p-5">
			<h1 class="text-center innerpage-title">
				<?php
					if(is_day()){
						printf( __( 'Daily Archives: %s', 'rocket' ), '<span>' . get_the_date() . '</span>' );
					}else if(is_month()){
						printf( __( 'Monthly Archives: %s', 'rocket' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'rocket' ) ) . '</span>' );
					}else if (is_year()){
						printf( __( 'Yearly Archives: %s', 'rocket' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'rocket' ) ) . '</span>' );
					}else{
						_e( 'Archives', 'rocket' );
					}
				?>
			</h1>
		</header><!-- .archive-header -->
		<div class="container">
			<div class="row" role="main">
				<div class="col-md-8">
				<?php if ( have_posts() ) { ?>
						<?php
							/* Start the Loop */
							while (have_posts()) { 
								the_post();
								?>
									<div class="index-lists">
										<div class="row">
											<div class="col-md-3">
												<?php if(has_post_thumbnail()){?>
													<?php echo '<img title="'.get_the_title().'" alt="'.get_the_title().'" class="img-fluid wp-post-image" src="'.wp_get_attachment_url( get_post_thumbnail_id() ).'" width="100%" height="auto" />';?>
												<?php }else{
													echo '<img class="img-fluid" src="//placehold.it/171x180" draggable="false" alt="No Image" title="No Image" />';
												} ?>											
											</div>
											<div class="col-md-9">
												<h2><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
												<span class="date-posted"><span class="glyphicon glyphicon-time"></span>&nbsp;<?php echo get_the_date(); ?></span>
												<br/>
												<p><?php echo substr(get_the_excerpt(), 0,200) ;?>...</p>
												<div class="archive-action">
													<a class="btn btn-primary" href="<?php echo get_the_permalink(); ?>"><span class="glyphicon glyphicon-search"></span> Read more</a>
												</div>
											</div>
										</div>
									</div>
								<?php
							} 
							wp_reset_query(); // end of the loop.
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
		</div><!-- .container-->
	</div><!-- .primary -->
<?php get_footer(); ?> 