<?php
/* Anagram / geet custom code below
	Gets all votes over 2 and displays them in order.
*/

global  $gravityview_view;


$criteria['paging'] = array(
			'offset' => 0,
			'page_size' => 200
);
$entries = gravityview_get_entries( 71, $criteria );
foreach ( $entries as $entry ) :

$bridge_id = GravityView_Ratings_Reviews_Helper::get_post_bridge_id( $entry['id'] );

if(!$bridge_id)continue;

$reviews_number       = GravityView_Ratings_Reviews_Helper::get_reviews_number( $bridge_id );
$review_rating_type   = $gravityview_view->atts['entry_review_type'];

$entry_voting = GravityView_Ratings_Reviews_Helper::get_review_average_rating( $bridge_id );

if($entry_voting["total_voters"]<=2)continue; //hide if minimum vote is equal or below 2

//echo '<div class="clear"></div><pre>';var_dump($entry);echo '</pre>';

if ( 'vote' === $review_rating_type ) {
	$votetype = $entry_voting["average_vote"];
	}else{
	$votetype = $entry_voting["average_stars"];
	};
$entry_results[] = array(
	'id'=> $bridge_id,
	'review_notes' => $entry['10'],
	'email' => $entry['3'],
	'starred' => $entry['is_starred'],
	'sortit' => $votetype,
	'get_review_title' =>  $entry['4'],
	'applicant_name' =>  $entry['2.3'].' '.$entry['2.6'],
	//'get_cat' => $entry[82],
	'get_review_url' => GravityView_API::entry_link( $entry ),
	'entry_average_rating' => $entry_voting
);
//echo GravityView_Ratings_Reviews_Helper::get_reviews_number( $bridge_id ).'ID: '.$bridge_id.'<br/>';


endforeach;

usort($entry_results, function($a, $b) {
    return $b['sortit'] > $a['sortit'] ? 1 : -1;
}); ?>


	<h1 class="page-title">Current Votes
		 <div class="small"><em>*Only displaying entry results that have 3 or more ratings.</em></div>
	</h1>


<ol id="highest" class="gv-review-list comment-list" style="padding-left: 20px;">
<?php foreach ( $entry_results as $entry_result ) :
	//var_dump($entry_result); ?>
<li class="comment-body" style="    padding-bottom: 10px;">
	 <div class="gv-review-rating-aggregate" style="    display: inline-block; margin-right: 20px;">


				<?php
			if ( 'vote' === $review_rating_type ) {
				GravityView_Ratings_Reviews_Helper::the_vote_rating( array(
					'rating'       => $entry_result['entry_average_rating']['average_vote'],
					'number'       => $entry_result['entry_average_rating']['total_voters'],
					'display_text' => false,
				) );
			} else {
				GravityView_Ratings_Reviews_Helper::the_star_rating( array(
					'rating'       => $entry_result['entry_average_rating']['average_stars'],
					'type'         => 'rating',
					'number'       => $entry_result['entry_average_rating']['total_voters'],
					'display_text' => false,
				) );
			}
			?>


				</div>
		<a href="<?php echo $entry_result['get_review_url']; ?>" title="<?php echo $entry_result['get_review_title']; ?>"><?php echo $entry_result['get_review_title']; ?></a> -  <?php echo $entry_result['applicant_name']; ?> - <?php echo $entry_result['email']; ?>
<div class="total-votes" style="float: right"><?php /* echo anagram_has_voted($entry['id']) ?> - Total Votes: <?php echo $entry_result['entry_average_rating']['total_voters'] ; */ ?> <?php echo $entry_result['review_notes']; ?> <?php if($entry_result['starred']) { echo '<i class="fa fa-check-circle-o fa-fw" aria-hidden="true" style="color:green"></i>';}else{ ?> <i class="fa fa-fw" aria-hidden="true" style="color:red"></i><?php }; ?></div>

</li>

<?php endforeach; ?>

    </ol>
</div>
