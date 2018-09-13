			</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .main content -->
<div class="container container-footer">


		<div class="row">
			<div class="site-footer-inner col-sm-12">
<footer id="colophon" class="site-footer" role="contentinfo">
		        <?php wp_nav_menu(
		                array(
		                    'theme_location' => 'footer',
		                    'container_id' => 'footer-menu-holder',
		                    'container_class' => 'clearfix',
		                    'menu_class' => 'nav navbar-nav navbar-right',
		                    'fallback_cb' => '',
		                    'menu_id' => 'footer-menu',
		                    'walker' => new wp_bootstrap_navwalker()
		                )
		            ); ?>

				<div class="site-info">

<div class="clearfix copyright"><span>&copy;<?php echo bloginfo('title'); ?>  <?php echo date('Y'); ?></span></div>
<div class="footer-credit"> Handcrafted by <a href="http://anagr.am" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/img/anagram/anagram-logo.png" alt="Anagram"  /></a></div>

				</div><!-- close .site-info -->


</footer><!-- close #colophon -->
			</div>
		</div>
		<!-- BACK TO TOP BUTTON -->
<div id="backtotop">
 <a id="toTop" href="#" onClick="return false"><i class="fa fa-chevron-up fa-lg"></i></a>
</div>
</div><!-- close .container -->

<?php wp_footer(); ?>

</body>
</html>
