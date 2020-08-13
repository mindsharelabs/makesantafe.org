
</div>


<!-- footer -->
<footer class="bottom-footer" role="contentinfo">
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
<?php wp_footer(); ?>


</body>
</html>
