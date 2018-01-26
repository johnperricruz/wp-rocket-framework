<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php 
			if (has_post_thumbnail(get_the_ID())){ 
				$image = wp_get_attachment_image_src( get_post_thumbnail_id(  get_the_ID() ), 'single-post-thumbnail' );
				echo'
					<div class="row"> 
						<div class="col-md-3 col-xs-6"> 
							<a href="#" class="thumbnail"> 
								<img title="'.get_the_title().'" alt="'.get_the_title().'" data-src="'.$image[0].'" style="" src="'.$image[0].'" data-holder-rendered="true" /> 
							</a> 
						</div>
					</div>
				';
			}
		?>
		<?php echo the_content(); ?>
	</article><!-- #post -->