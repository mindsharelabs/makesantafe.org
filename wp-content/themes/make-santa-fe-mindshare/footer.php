<!-- footer -->
<footer class="bottom-footer pb-5" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="my-auto col-6 col-md-10">
        <p class="align-middle"> &copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>.</p>
      </div>
      <div class="my-auto col-6 col-md-2">
				<div class="footer-credit">
					<a href="http://anagr.am" target="_blank">
						<img src="<?php echo get_template_directory_uri() . '/img/anagram-logo.png'; ?>" alt="Hand Crafted by Anagram"  alt="Anagram" />
					</a>
					<a href="http://mind.sh/are" target="_blank">
						<img src="<?php echo get_template_directory_uri() . '/img/mindshare.svg'; ?>" title="Hand Crafted by Mindshare Labs, Inc" alt="Mindshare Labs, Inc"></a>
					</a>
				</div>
			</div>
		</div>
  </div>
</footer>


<?php
  // if(wc_memberships_is_user_active_member()) :
  //   echo '<div class="footerDrawer">';
  // 		echo '<div class="open">';
  //     echo '<h5 class="text-center">Member Menu <i class="fal fa-angle-double-up"></i></h5>';
  //   		echo '<div class="content">';
  //         mindblank_nav('member-menu');
  //   		echo '</div>';
  //     echo '</div>';
  // 	echo '</div>';
  //
  // endif;



?>



<!-- /footer -->
</div>
<?php wp_footer(); ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-74379401-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-74379401-1');
</script>

</body>
</html>
