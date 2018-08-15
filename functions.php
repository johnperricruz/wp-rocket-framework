<?php
	 require_once('libs/wp_bootstrap_navwalker.php');
	 require_once('libs/class-tgm-plugin-activation.php');
	 
	/**
     * Rocket CSS : PUT CSS HERE
     */
	function rocketStyle(){

			//Font awesome
			if(get_option('font_awesome') == "true") { 
				wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css' );
			}	

			//Owl
			if(get_option('owl') == "true") { 		
				wp_enqueue_style( 'owl-css', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.carousel.min.css');
				//wp_enqueue_style( 'owl-transition-min', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.transitions.min.css');	
				wp_enqueue_style( 'owl-theme-min', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.theme.default.css');	
			}	
			
			//Pace https://cdnjs.com/libraries/pace
			wp_enqueue_style( 'pace-css', 'https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-flash.min.css');
			
			//Rocket CSS
			wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
			wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css');	
			wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css');				
	}
	
	/**
	 * Rocket JS : PUT JS HERE
	 */
	function rocketScript(){
		//JS
		if(get_option('scroll_reveal') == "true") { 
			wp_enqueue_script( 'scroll-reveal',  '//cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/3.1.4/scrollreveal.min.js',array('jquery'));
		}
		if(get_option('owl') == "true") { 
			wp_enqueue_script( 'owl-js', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js',array('jquery'));
		}	
		if(get_option('parallax') == "true") { 
			wp_enqueue_script( 'parallax', '//cdnjs.cloudflare.com/ajax/libs/jquery-parallax/1.1.3/jquery-parallax.js',array('jquery'));
		}
		
		//Pace
		//wp_enqueue_script( 'pace-js', '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',array('jquery'));
		
		//Load core file
		wp_enqueue_script( 'rocket-tether-js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery'));	
		wp_enqueue_script( 'rocket-bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'));	
		wp_enqueue_script( 'rocket-script', get_template_directory_uri() . '/assets/js/script.js',array('jquery'));
		
		//Transfer Scripts to footer
		// remove_action('wp_head', 'wp_print_scripts'); 
	    // remove_action('wp_head', 'wp_print_head_scripts', 9); 
	    // remove_action('wp_head', 'wp_enqueue_scripts', 1);
 
	    // add_action('wp_footer', 'wp_print_scripts', 5);
	    // add_action('wp_footer', 'wp_enqueue_scripts', 5);
	    // add_action('wp_footer', 'wp_print_head_scripts', 5); 
	}

	/**
	 * Remove script version
	 */
	function removeScriptVersion( $src ){
		$parts = explode( '?ver', $src ); 
		return $parts[0];
	}
	
	/**
	 * Async All JS
	 */
	function asyncJS ( $url ) {
		if ( FALSE === strpos( $url, '.js' ) ) return $url;
		if ( strpos( $url, 'jquery.js' ) ) return $url;
		return "$url'  async='async"; 
	}
	
	/**
	 * Get Rocket Navigation
	 */
	function getMenuNavigation(){
		$nav =  wp_nav_menu( 
					array(
						'menu'              => 'primary',
						'theme_location'    => 'primary',
						'depth'             => 4,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse desktop',
						'container_id'      => 'bs-navbar-collapse',
						'menu_class'        => 'nav navbar-nav',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'walker'            => new wp_bootstrap_navwalker()
					)
				);
		return $nav;
	}
	/**
	 * Sidebar
	 */
	function rocketSidebar() {
		register_sidebar( array(
			'name' => __( 'Primary Sidebar', 'rocket' ),
			'id' => 'primary-sidebar',
			'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'rocket' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
	
	/*
	* Pull Blogpost
	*/
	function pull_blog_posts($atts, $content = null){
	    extract(shortcode_atts(array(
		   'posts' => 1,
		   'cat' => 1,
		   'template'  => 'blogs'
	    ), $atts));
		
		$return = '';
		
		$args = array(
			'orderby' => 'date', 
			'order' => 'DESC' , 
			'showposts' => $posts, 
			'cat' => $cat
		);
		
		$query = new WP_Query($args);
		
		$return = array();
		
		if($query->have_posts()){
			
			while($query->have_posts()){  
			$query->the_post();
				/*Pull news template*/
					$return['news'] .= '
						<a href="'.get_the_permalink().'">'.get_the_post_thumbnail(get_the_ID(), array(300,300)).'</a>
						'.get_the_title().'
						'.rocket_excerpt(200).'
						'.get_the_permalink().'
					';
				/*End Pull news template*/		
				
			}
			
		}
		switch($template){
			case 'news' : 			
				$return = $return['news'];
			break;
		}
		wp_reset_query();
	    return $return;
	}
	
	/**
	 * Pagination
	 */

	function rocketPage() {
		global $wp_query;
		$big = 999999999; // need an unlikely integer
		
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'prev_text'          => __('«'),
			'next_text'          => __('»'),
			'total' => $wp_query->max_num_pages
		) );
	}
	/**
	 * Register Theme Options
	 */
	function rocketThemeOptions(){
		  add_menu_page( 
			  'Theme Options', 			//Page Title
			  'Theme Options',  		//Menu Title
			  'manage_options', 		//Capability
			  'theme-options', 			//Page ID
			  'rocketThemeOptionsPage',	//Functions
			  null, 					//Favicon
			  99						//Position
		  );
	}
	/**
	 * Theme Options Page
	 */
	function rocketThemeOptionsPage() {
		echo '<div class="wrap">';
			echo '<h1>Primeview Rocket Theme Options</h1>';
			echo '<form method="post" action="options.php">';
				settings_fields( 'option-group' );
				do_settings_sections( 'option-group' );
				echo '<div class="shortcodes">';
						echo "<h2>Social Media Shortcode</h2>";
							echo "<p><b>Shortcode :</b> ".stripslashes('[social-media]')." </p>";
							echo "<p><b>Parameters : </b>".stripslashes('mode = facebook , twitter , google_plus , linkedin , youtube , instagram , pinterest')." </p>";
							echo "<p><b>Example : </b>".stripslashes('[social-media mode="facebook"]')." </p>";
						echo "<h2>Copyright and Developer Shortcode</h2>";
						echo "<p><b>Get Developer Part : </b> ".stripslashes('[developer]')."</p>";
						echo "<p><b>Get Copyright Part : </b> ".stripslashes('[copyright]')."</p>";
				echo '</div>';
				echo '<h3>I. Social Media</h3>';
				echo '<table class="jpc-table">';
					echo '<tr>';
						echo '<td>Facebook: </td>';
						echo '<td><input placeholder="Facebook" type="text" name="facebook" value="'. esc_attr( get_option('facebook') ).'" /> </td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Twitter: </td>';
						echo '<td><input placeholder="Twitter" type="text" name="twitter" value="'. esc_attr( get_option('twitter') ).'" /></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Google Plus: </td>';
						echo '<td><input placeholder="Google Plus" type="text" name="google_plus" value="'. esc_attr( get_option('google_plus') ).'" /></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>LinkedIn: </td>';
						echo '<td><input placeholder="LinkedIN" type="text" name="linkedin" value="'. esc_attr( get_option('linkedin') ).'" /></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Youtube: </td>';
						echo '<td><input placeholder="Youtube" type="text" name="youtube" value="'. esc_attr( get_option('youtube') ).'" /></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Instagram: </td>';
						echo '<td><input placeholder="Instagram" type="text" name="instagram" value="'. esc_attr( get_option('instagram') ).'" /></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Pinterest: </td>';
						echo '<td><input placeholder="Pinterest" type="text" name="pinterest" value="'. esc_attr( get_option('pinterest') ).'" /></td>';
					echo '</tr>';				
				echo '</table>';
				echo '<h3>II. Website Settings</h3>';
				echo '<table class="jpc-table">';
					echo '<tr>';
						echo '<td>Frontend Favicon: </td>';
						echo '<td><input placeholder="Frontend Favicon" type="text" name="favicon" value="'. esc_attr( get_option('favicon') ).'" /></td>';
					echo '</tr>';	
					echo '<tr>';
						echo '<td>Backend Favicon: </td>';
						echo '<td><input placeholder="Admin Backend Favicon" type="text" name="admin_favicon" value="'. esc_attr( get_option('admin_favicon') ).'" /></td>';
					echo '</tr>';										
				echo '</table>';
				echo '<h3>III. Enable Theme Features</h3>';
				echo '<table class="jpc-table">';	
					echo '<tr>';
						echo '<td>FontAwesome v4.4.0 : </td>';
						?><td><input type="checkbox" name="font_awesome" value="true" <?php if(get_option('font_awesome') == "true") echo "checked"; ?> /> <a target="_blank" href="https://fortawesome.github.io/Font-Awesome/icons/">Read Documentation</a></td><?php
					echo '</tr>';		
					echo '<tr>';
						echo '<td>Scroll Reveal : </td>';
						?><td><input type="checkbox" name="scroll_reveal" value="true" <?php if(get_option('scroll_reveal') == "true") echo "checked"; ?> /><a target="_blank" href="https://github.com/jlmakes/scrollreveal.js">Read Documentation</a> </td><?php
					echo '</tr>';		
					echo '<tr>'; 
						echo '<td>Owl Carousel v2.3.3: </td>';
						?><td><input type="checkbox" name="owl" value="true" <?php if(get_option('owl') == "true") echo "checked"; ?> /> <a target="_blank" href="https://owlcarousel2.github.io/OwlCarousel2/demos/basic.html">Read Documentation</a> </td><?php
					echo '</tr>';	
					echo '<tr>';
						echo '<td>JS Parallax Scrolling : </td>';
						?><td><input type="checkbox" name="parallax" value="true" <?php if(get_option('parallax') == "true") echo "checked"; ?> /> Example :  $("SELECTOR").parallax("50%", 0.1); </td><?php
					echo '</tr>';					
				echo '</table>';	
				echo '<h3>IV. Copyright Section</h3>';
				
				echo '<table class="jpc-table">';	
					echo '<tr>';
						echo '<td>Copyright : </td>';
						echo '<td><textarea rows="6" type="text" name="copyright" value="'. esc_attr( get_option('copyright') ).'" >'. esc_attr( get_option('copyright') ).'</textarea></td>';
					echo '</tr>';		
					echo '<tr>';
						echo '<td>Developer : </td>';
						echo '<td><textarea rows="6" type="text" name="developer" value="'. esc_attr( get_option('developer') ).'" >'. esc_attr( get_option('developer') ).'</textarea></td>';
					echo '</tr>';				
				echo '</table>';
				
				echo '<h3>V. Third Party Scripts</h3>';
				
				echo '<table class="jpc-table">';	
					echo '<tr>';
						echo '<td>Third Party Scripts : </td>';
						echo '<td><textarea rows="10" type="text" name="rocket_scripts" value="'. esc_attr( get_option('rocket_scripts') ).'" >'. esc_attr( get_option('rocket_scripts') ).'</textarea></td>';
					echo '</tr>';						
				echo '</table>';
				
				submit_button();
			echo'</form>';
		echo'</div>';
	}

	/**
	 * Register Theme Settings
	 */
	function rocketThemeSettings() {
		register_setting( 'option-group', 'facebook' );
		register_setting( 'option-group', 'twitter' );
		register_setting( 'option-group', 'google_plus' );
		register_setting( 'option-group', 'linkedin' );
		register_setting( 'option-group', 'youtube' );
		register_setting( 'option-group', 'instagram' );
		register_setting( 'option-group', 'pinterest' );
		register_setting( 'option-group', 'favicon' );
		register_setting( 'option-group', 'admin_favicon' );
		register_setting( 'option-group', 'font_awesome' );
		register_setting( 'option-group', 'scroll_reveal' );
		register_setting( 'option-group', 'owl' );
		register_setting( 'option-group', 'parallax' );
		register_setting( 'option-group', 'loader' );
		register_setting( 'option-group', 'copyright' );
		register_setting( 'option-group', 'developer' );
		register_setting( 'option-group', 'rocket_scripts' );
		
	}
	function developerShortcode( $atts ) { 
		return do_shortcode(get_option('developer'));
	}

	function copyrightShortcode( $atts ) { 
		return do_shortcode(get_option('copyright'));
	}

	/**
	 * Social Media Shortcode
	 */
	function socialMediaShortcode( $atts ) {
		// Assign default values
		
		$mode   = "";
		$return = "Invalid value!";
		
		extract( shortcode_atts( array(
			'mode' =>  $mode
		), $atts ) );
		
		if($mode == "facebook"){
			$return = get_option('facebook');
		}
		else if($mode == "twitter"){
			$return = get_option('twitter');
		}
		else if($mode == "google_plus"){
			$return = get_option('google_plus');
		}
		else if($mode == "linkedin"){
			$return = get_option('linkedin');
		}
		else if($mode == "youtube"){
			$return = get_option('youtube');
		}
		else if($mode == "instagram"){
			$return = get_option('instagram');
		}
		else if($mode == "pinterest"){
			$return = get_option('pinterest');
		}
		
		return $return;
	}

	/**
	 * Get Present Year
	 */
	function getPresentYear( $atts ){
		return date('Y');
	}
	
	/**
	 * Admin Favicon
	 */
	function adminFavicon() {
		echo '<link href="'.get_option('admin_favicon').'" rel="icon" type="image/x-icon">';
	}
	
	function excerpt_more( $more ) {
		return '';
	}
	
	function rocket_excerpt($length) {
		if(strlen(get_the_excerpt()) >= $length){
			$excerpt =  substr(get_the_excerpt(),0,$length).'...';
		}else{
			$excerpt = get_the_excerpt();
		}
		return $excerpt;
	}
	
	/**
	 * Custom Blog Pagination
	 */
	function my_pagination() {
		global $wp_query;

		$big = 999999999; // need an unlikely integer
		
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
	}

	function requiredPlugins() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// This is an example of how to include a plugin bundled with a theme.
			array(
				'name'               => 'Contact Form DB', // The plugin name.
				'slug'               => 'contact-form-7-to-database-extension', // The plugin slug (typically the folder name).
				'source'             => get_stylesheet_directory() . '/plugins/contact-form-7-to-database-extension-2.10.32.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
			array(
				'name'               => 'Revolution Slider', // The plugin name.
				'slug'               => 'revslider', // The plugin slug (typically the folder name).
				'source'             => get_stylesheet_directory() . '/plugins/revslider.zip', // The plugin source.
				'required'           => false, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
			
			array(
				'name'      => 'Max Mega Menu', //repo name
				'slug'      => 'megamenu', //url
				'required'  => true,
				'force_activation' => true,
				'force_deactivation' => false
			),
			array(
				'name'      => 'Google Analyticator', //repo name
				'slug'      => 'google-analyticator', //url
				'required'  => true,
				'force_activation' => true,
				'force_deactivation' => false
			),
			array(
				'name'      => 'Display Widgets', //repo name
				'slug'      => 'display-widgets', //url
				'required'  => true,
				'force_activation' => true,
				'force_deactivation' => false
			),
			array(
				'name'      => 'Yoast SEO', //repo name
				'slug'      => 'wordpress-seo', //url
				'required'  => true,
				'force_activation' => true,
				'force_deactivation' => false
			),
			array(
				'name'      => 'Contact Form 7', //repo name
				'slug'      => 'contact-form-7', //url
				'required'  => true,
				'force_activation' => true,
				'force_deactivation' => false
			),
			array(
				'name'      => 'WP Owl Carousel', //repo name
				'slug'      => 'wp-owl-carousel', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			),
			array(
				'name'      => 'FooGallery', //repo name
				'slug'      => 'foogallery', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			),
			array(
				'name'      => 'FooBox', //repo name
				'slug'      => 'foobox-image-lightbox', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			),
			array(
				'name'      => 'W3 Total Cache', //repo name
				'slug'      => 'w3-total-cache', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			),
			array(
				'name'      => 'Advanced Custom Fields', //repo name
				'slug'      => 'advanced-custom-fields', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			),
			array(
				'name'      => 'Simple Job Board', //repo name
				'slug'      => 'simple-job-board', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			),
			array(
				'name'      => 'WooCommerce', //repo name
				'slug'      => 'woocommerce', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			),
			array(
				'name'      => 'BuddyPress', //repo name
				'slug'      => 'buddypress', //url
				'required'  => false,
				'force_activation' => false,
				'force_deactivation' => false
			)
		);

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => __( 'Rocket Framework Recommended Plugins', 'tgmpa' ),
				'menu_title'                      => __( 'Rocket Framework Plugins', 'tgmpa' ),
				'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
				'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
				'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
				'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);

		tgmpa( $plugins, $config );

	}
	function woo_new_review_product_tab( $tabs ) {
		// Adds the new tab
		$tabs['tab_reviews'] = array(
			'title' 	=> __( 'Reviews ('.get_comments_number().')', 'woocommerce' ),
			'priority' 	=> 50,
			'callback' 	=> 'woo_new_review_product_tab_content'
		);
		return $tabs;
	}
	function woo_new_review_product_tab_content() {
		// The new tab content
		echo '<h2>Customer Reviews : </h2>';
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;	
	}
	/**
	 * Function Init 
	 */
	function launchRocket(){
		/**
		 * Load on frontend
		 */

		add_action( 'wp_enqueue_scripts', 'rocketScript' );
		
		/**
		 * Inline CSS 
		 */
		add_action( 'wp_head', 'rocketStyle',100);
		
		/**
		 * Remove Version
		 */
		add_filter( 'script_loader_src', 'removeScriptVersion', 15, 1 );
		add_filter( 'style_loader_src', 'removeScriptVersion', 15, 1 );
		
		/**
		 * Excerpt Length
		 */
		// add_filter('excerpt_length', 'new_excerpt_length');	
		  
		/**
		 * Async JS Version
		 */
		//add_filter( 'clean_url', 'asyncJS', 11, 1 );
	
		/** 
		 * Load on admin
		 */
		if(is_admin()){
			wp_enqueue_style('backend-css-styles', get_template_directory_uri().'/assets/css/backend.css');
			
			/**
			 * Theme Options
			 */
			add_action( 'admin_menu', 'rocketThemeOptions' );
			add_action( 'admin_init', 'rocketThemeSettings');
			
			/** 
			 * Admin Favicon
			 */
			 add_action('admin_head', 'adminFavicon');
			 
			/**
			 * Theme Features
			 */
			 add_theme_support( 'post-thumbnails' ); 
			 
			  

		}
		/**
		 * Plugin Dep
		 */
		 add_action( 'tgmpa_register', 'requiredPlugins' ); 
		  
		/**
		 * Sidebar
		 */		
		 
		add_action( 'widgets_init', 'rocketSidebar' );	 	
		//add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );	
		
		/**
		 * Rocket Menu
		 */
		register_nav_menu( 'primary', __( 'Primary Menu', 'rocket' ) );
		register_nav_menu( 'mobile', __( 'Mobile Menu', 'rocket' ) );

		/**
		 * Shortcode
		 */
		 
		add_filter( 'woocommerce_product_tabs', 'woo_new_review_product_tab' );
		add_shortcode( 'rocketmenu', 'getMenuNavigation' ); //[rocketmenu]
		add_shortcode( 'year', 'getPresentYear' ); //[year]
		add_shortcode( 'social-media', 'socialMediaShortcode' ); //[social-media mode="facebook"]
		add_shortcode( 'copyright', 'copyrightShortcode' ); //[copyright]
		add_shortcode( 'developer', 'developerShortcode' ); //[developer]
		add_shortcode('recent-posts', 'pull_blog_posts'); //[recent-posts posts=5 template=news ]
	}	
	
	/** 
	 * Initialize WP Rocket Framework
	 */
	launchRocket();

