<?php
/**
 * The template for displaying Category pages
 *
 */
get_header(); ?>
	<div id="primary" class="category-<?=get_queried_object_id();?> category site-content">
		<div class="container">
			<div class="row" role="main">
				<div class="col-md-8">
						<?php 	
						$category = $wp_query->get_queried_object();
						
						$paged = ( get_query_var('paged') ? get_query_var('paged') : 1);
						$query = array(
							'cat' => get_queried_object_id(),
							'post_type' => 'post',
							'paged' => $paged, 
						);
						query_posts( $query );						
						if (have_posts()){
							?>
						<header class="category-header">
							<h1 class="category-title"><?php echo $category->name; ?></h1>
						</header><!-- .archive-header -->
						<?php						
							while(have_posts()){ 
								the_post();
								?>
									<div class="category-lists">
										<div class="row">
											<div class="col-md-3">
												<?php if(has_post_thumbnail()){?>
													<?php echo '<img title="'.get_the_title().'" alt="'.get_the_title().'" class="wp-post-image" src="'.wp_get_attachment_url( get_post_thumbnail_id() ).'" width="100%" height="auto" />';?>
												<?php }else{
													echo '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTcxIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE3MSAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTU5NmFlOGYzZTQgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTk2YWU4ZjNlNCI+PHJlY3Qgd2lkdGg9IjE3MSIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI2MSIgeT0iOTQuNSI+MTcxeDE4MDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" draggable="false" alt="No Image" title="No Image" />';
												} ?>
											</div>
											<div class="col-md-9">
												<h2><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
												<span class="date-posted"><span class="glyphicon glyphicon-time"></span>&nbsp;<?php echo get_the_date(); ?></span>
												<br/>
												<p><?php echo substr(get_the_excerpt(), 0,200) ;?>...</p>
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
		</div><!-- .container-->
	</div><!-- .primary -->
<?php get_footer(); ?> 