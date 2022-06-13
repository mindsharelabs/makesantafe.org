
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

<!-- Modal -->
<?php if(get_field('enable_member_modal', 'options') && is_user_logged_in()) : ?>
  <div class="modal fade" id="memberModal" data-modalid="<?php echo get_option( 'make-member-modal-slug'); ?>" tabindex="-1" role="dialog" aria-labelledby="memberInformationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="memberInformationModal"><?php the_field('member_modal_title', 'options'); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times"></i></span>
          </button>
        </div>
        <div class="modal-body">
          <?php the_field('member_modal_content', 'options'); ?>
        </div>
        <?php if($button = get_field('member_modal_button', 'options')) : ?>
          <div class="modal-footer">
            <a class="btn btn-primary btn-block" href="<?php echo $button['button_link']; ?>"><?php echo $button['button_text']; ?></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
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
