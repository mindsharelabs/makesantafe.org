<?php
/**
 * Display a single entry when using a table template
 *
 * @package GravityView
 * @subpackage GravityView/templates
 *
 * @global GravityView_View $this
 */
?>
<?php gravityview_before(); ?>

<div class="gv-back-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo gravityview_back_link(); ?></div>
<div class="gv_pagination"><?php echo anagram_entry_pagintion(); ?></div>
<div class="gv-table-view gv-container gv-table-single-container">
	<table class="gv-table-view-content table">
		<?php if( $this->getFields('single_table-columns') ) { ?>
			<thead>
				<?php gravityview_header(); ?>
			</thead>
			<tbody>
				<?php

					$markup = '
						<tr id="{{ field_id }}" class="{{class}}">
							<th scope="row">{{label}}</th>
							<td data-title="{{label_value}}">{{value}}</td>
						</tr>';

					$this->renderZone( 'columns', array(
						'markup' => $markup,
					));
			?>
			</tbody>
			<tfoot>
				<?php gravityview_footer(); ?>

			</tfoot>
		<?php } ?>
	</table>
</div>
<?php gravityview_after(); ?>
