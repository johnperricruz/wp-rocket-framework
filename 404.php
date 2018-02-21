<?php
/**
 * The template for displaying all 404 Pages
 *
 */
get_header(); ?>
	<div id="primary" class="404 site-content">
		<header class="innerpage-header p-5">
			<h1 class="text-center innerpage-title">404 : Page not found</h1>
		</header>
		<div class="container">
			<div class="row" role="main">
				<div class="col-md-8">
					<dl>
						<dt>The page you requested was not found, and we have a fine guess why.</dt>
						<dd>
							<ul class="disc">
								<li>If you typed the URL directly, please make sure the spelling is correct.</li>
								<li>If you clicked on a link to get here, the link is outdated.</li>
							</ul>
						</dd>
					</dl>
					<dl>
						<dt>What can you do?</dt>
						<dd>Have no fear, help is near! There are many ways you can get back on track with this site.</dd>
						<dd>
							<ul class="disc">
								<li><a href="#" onclick="history.go(-1); return false;">Go back</a> to the previous page.</li>
								<li>Use the search bar at the top of the page to search.</li>
								<li>Follow these links to get you back on track! <a href="<?php echo get_site_url(); ?>">Home</a> 
							</ul>
						</dd>
					</dl>
				</div><!-- .col-md-8 -->
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div><!-- .col-md-4 -->
			</div><!--.row -->
		</div><!-- .container-fluid -->
	</div><!-- .primary -->
<?php get_footer(); ?>