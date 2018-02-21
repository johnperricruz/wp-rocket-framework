			<footer class="footer">
			  <div class="container">
				<span class="text-muted">Primeview Rocket Framework. Fast. Premium. Effective</span>
			  </div>
			</footer>
		</div>
		<?php wp_footer(); ?>
		<?php
			if(get_option('rocket_scripts')!=null){
				echo get_option("rocket_scripts");		
			}
		?>
	</body>
</html>