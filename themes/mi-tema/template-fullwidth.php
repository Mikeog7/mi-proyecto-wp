<?php
/*
Template Name: Ancho completo (sin título)
Template Post Type: page
*/
get_header(); ?>

<main class="site-main site-main--full">
  <?php while (have_posts()) : the_post(); ?>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>