			<footer class="footer">
			  <div class="container">
				<span class="text-muted">Primeview Rocket Framework. Fast. Premium. Effective</span>
			  </div>
			</footer>
		</div>
		<?php wp_footer(); ?>
		<?php
			if(get_option('rocket_scripts')!=null){
				echo '
					<script type="text/javascript" id="third-party-scripts">
						'.get_option("rocket_scripts").'
						
					</script>
				';		
			}
			if(get_option('loader')==true){
				echo '
					<script>
						$j = jQuery.noConflict();
						$j(function(){
							$j(".fakeloader").fakeLoader({
								timeToHide:1200,
								bgColor:"#2ecc71",
								spinner:"spinner1"
							});  			
							$j("body").attr({style:"visibility:visible;background:#fff;"});
						});
					</script>
				';
			}
		?>
	</body>
</html>