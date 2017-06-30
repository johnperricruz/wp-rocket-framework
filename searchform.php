<form action="<?php echo get_site_url(); ?>" method="get">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="input-group">
					<input class="form-control" placeholder="Search for..." name="s" id="search" value="<?php the_search_query(); ?>" /> 
					<span class="input-group-btn"> 
						<button class="btn btn-default" type="submit">Search</button> 
					</span> 
				</div>
			</div>
		</div>
	</div>
</form>
