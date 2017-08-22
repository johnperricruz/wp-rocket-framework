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
						$loader = jQuery.noConflict();
						$loader(function(){
							$j(".fakeloader").fakeLoader({
								timeToHide:1500,
								bgColor:"#2ecc71",
								spinner:"spinner1"
							});  					
							$j("body").attr({style:"background-color:#fff;visibility:visible;"});							
						});
					</script>
				';
			}
		?>
	</body>
</html>