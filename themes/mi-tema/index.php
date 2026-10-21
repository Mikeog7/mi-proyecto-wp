<?php get_header(); ?>

<main class="container">
  <div class="posts-grid">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="post-card">
        <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_excerpt(); ?>
      </article>
    <?php endwhile; else : ?>
      <p>No hay contenido todavía.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>