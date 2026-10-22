<?php get_header(); ?>

<main class="site-main">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('entry'); ?>>
      <header class="container entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="entry-meta"><?php echo get_the_date(); ?></p>
      </header>

      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>