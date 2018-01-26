<?php
/**
 * Template Name: Empty page Template
 *
 */
get_header(); 
	while (have_posts()){ 
		the_post(); 
		the_content();
	} 				
get_footer(); ?>