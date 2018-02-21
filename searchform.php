<form class="search-form" action="<?php echo get_site_url(); ?>" method="get">

	<div class="input-group">
		<input class="form-control" placeholder="Search for..." name="s" id="search" value="<?php the_search_query(); ?>" /> 
		<span class="input-group-append"> 
			<button class="btn btn-default" type="submit">Search</button> 
		</span> 
	</div>

</form>
