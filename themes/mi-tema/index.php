<?php get_header(); ?>

<section class="hero">
  <div class="container">
    <h2><?php bloginfo('name'); ?></h2>
    <p><?php bloginfo('description'); ?></p>
  </div>
</section>

<main class="container">
  <div class="posts-grid">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="post-card">
        <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_excerpt(); ?>
        <a class="btn" href="<?php the_permalink(); ?>">Leer mas</a>
      </article>
    <?php endwhile; else : ?>
      <p>No hay contenido todavia.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>