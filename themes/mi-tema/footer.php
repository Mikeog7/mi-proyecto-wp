<footer class="site-footer">
  <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
    <div class="container footer-widgets">
      <?php for ($i = 1; $i <= 3; $i++) : ?>
        <?php if (is_active_sidebar("footer-$i")) : ?>
          <div class="footer-col">
            <?php dynamic_sidebar("footer-$i"); ?>
          </div>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  <?php endif; ?>

  <div class="container footer-bottom">
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados.</p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>