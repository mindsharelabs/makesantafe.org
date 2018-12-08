			<!-- footer -->
			<footer class="bottom-footer container-fluid" role="contentinfo">
                <div class="row">
                    <div class="my-auto col-8 col-md-10">
                        <p class="align-middle"> &copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>.</p>
                    </div>
                    <div class="my-auto col-4 col-md-2">
											<div class="footer-credit">
												<a href="http://anagr.am" target="_blank">
													<img src="<?php bloginfo('template_directory'); ?>/img/anagram-logo.png" alt="Anagram"  />
												</a>
												<a href="http://mind.sh/are" target="_blank">
													<img src="<?php echo get_template_directory_uri() . '/img/mindshare.svg'; ?>" title="Hand Crafted by Mindshare Labs, Inc" alt="Mindshare Labs, Inc"></a>
												</a>
											</div>

                    </div>
                </div>
			</footer>
			<!-- /footer -->

		</div>

		<?php wp_footer(); ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-16159409-37"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', 'UA-16159409-37');
            </script>

	</body>
</html>
