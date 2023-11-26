<?php include 'layout/top-footer.php'; ?>
</div>


<!-- footer -->


<div class="container my-2">
	<div class="row border-top-dark">
		<div class="col-12 text-center mt-1 py-1 copyright">
			<p class="mb-0 small muted"> <i class="fas fa-copyright"></i> <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>. All rights reserved.</p>
		</div>
	</div>
	<div class="row  mindshare-credit ">
		<div class="text-center col-8 offset-2 col-md-2 offset-md-5">
			<div class="my-auto text-center">
				<a href="https://mind.sh/are" title="Mindshare Labs, Inc" style="color:#CAA74F">
					<i class="fak fa-2xl fa-mindshare"></i>
				</a>
			</div>
		</div>
	</div>
</div>
<!-- /footer -->

</div>
<?php


	echo '<nav id="mobileMenu" class="mobile-nav d-block d-md-none">';
		echo '<div class="mobile-logo mx-auto w-50 border-bottom pb-5">';
			echo '<a href="' . home_url() . '">';
				echo '<img src="' . get_template_directory_uri() . '/img/logo.svg' . '" width="188" height="100" title="' . get_bloginfo( 'name' ) . '" />';
			echo '</a>';
		echo '</div>';
		mindblank_nav('mobile-menu');
	echo '</nav>';

	echo '<nav id="mobileMenuToggle" class="menu-toggle d-flex d-md-none">';
		include get_template_directory() . '/img/menuToggle.svg';
	echo '</nav>';

wp_footer(); ?>


</body>
</html>
