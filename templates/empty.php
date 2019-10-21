<?php
/**
 * Template Name: Empty Page Template (DIVI)
 *
 */
    get_header(); 
        while (have_posts()){ 
            the_post(); 
            the_content();
        } 
    get_footer();
 ?>