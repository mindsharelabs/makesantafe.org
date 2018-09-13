<?php
/**
 * The template for displaying review list footer.
 *
 * @package GravityView_Ratings_Reviews
 * @since 0.1.0
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="gv-review-list-footer">
<div class="gv-back-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo gravityview_back_link(); ?></div>
<div class="gv_pagination"><?php echo anagram_entry_pagintion(); ?></div>
</div><!-- /.gv-review-list-footer -->