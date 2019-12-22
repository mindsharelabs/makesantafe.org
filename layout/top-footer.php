
<footer class="footer">
    <div class="container">
      <div class="row my-auto">
        <nav class="footer-menu">
          <?php mindblank_nav('member-menu'); ?>
        </nav>
      </div>
      <div class="row">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widgets')) ?>
      </div>
    </div>
</footer>
