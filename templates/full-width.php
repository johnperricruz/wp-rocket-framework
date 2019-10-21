<?php
/**
 * Template Name: Full-width, no sidebar Page Template (DIVI)
 *
 */
get_header(); ?>
    <header class="innerpage-header p-5">
        <h1 class="text-white text-center innerpage-title mb-5">
            <?php the_title(); ?>
        </h1>
        <?php
            if ( function_exists('yoast_breadcrumb') ) {
              yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            }
        ?>
    </header> 
    <?php 
        while (have_posts()){ 
            the_post(); 
            the_content();
        } 
    ?>                  
<?php get_footer(); ?>