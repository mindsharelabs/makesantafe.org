<?php
	/*
		Template Name: FundRaiser
		*/
		get_header(); ?>
		<div class="content">
	<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
					<?php if ( has_post_thumbnail() ) { ?>
		<?php echo anagram_resize_image(array('width'=>877, 'height'=>360, 'crop'=>true)); ?>
		<?php //be_display_image_and_caption('large');
			//the_post_thumbnail('large'); ?>
	<?php } ?>
		<?php the_content(); ?>



	    <?php

/*
	global $theformid, $donations;
    $theformid = get_field('donation_form_id', 2153);
    $goal = get_field('goal', 2153);
    $totalgoal = get_field('total_goal', 2153); //match to
    $over = false;
    ?>
    <script type="text/javascript">

    var goal = <?php echo $goal; ?>;
    var totalgoal = <?php echo $totalgoal; ?>;
    </script>

    <?php $donations = get_donations($theformid);
	    $auctions = anagram_auction_total()+anagram_get_total_buynow();
   // print_r($donations);
    $open = $donations['open'];
    $date = $donations['close'];
    $date_2 = date_i18n("Y-m-d");
    $open_diff=(strtotime($open)-strtotime($date_2)) / 86400;
    $date_diff=(strtotime($date)-strtotime($date_2)) / 86400;
    $donationstotal = $donations['total']+$auctions;





            if($donationstotal<=$goal){ //If donation amount exceeds the 15,000 limit, dont double amount.
                    if($goal != $totalgoal){ //if being matched
                            $tally = ($donationstotal*2);
                    }else{
                        $tally = $donationstotal;
                    }
            }else{
                    $tally = ($donationstotal+$goal);
                };



        if ( $tally == '' ) {
            $tally = 0;
        }
        $remaining = ($totalgoal - $tally);
        $funding_percentage = 1;
        if ( $remaining <= 0 ) {
            //$funding_percentage = 1;
            $over = true;
            $funding_percentage = ($totalgoal / $tally );
        } else if ( $tally < $totalgoal ) {
            $funding_percentage = ($tally / $totalgoal);
        }
        $goal_length = intval( ( 100 * $funding_percentage ) );




    $h = 24 - date_i18n("H")/1;
    $m = 60 - date_i18n("i")/1;
    $s = 60 - date_i18n("s")/1;
    //$h = (($h <10)?"0":"").$h;
    $m = (($m <10)?"0":"").$m;
    $s = (($s <10)?"0":"").$s;

   //var_dump($auctions);
   // var_dump($donations['total']);
if(strtotime($open)>strtotime($date_2)){
	$timeText = 'Drive opens in '.$open_diff.' days!';


}else{
	$timeText = ($date_diff!=1) ?  $date_diff.' days' :  "$h hours and $m minutes left!";
}
*/









	$download_id = 6512;
	$totalgoal = 4743;
	$goal = 4743;
	$total_sales     = edd_get_download_sales_stats( $download_id );
	$tally = edd_get_download_earnings_stats( $download_id );

/*
		 if($tally<=$goal){ //If donation amount exceeds the 15,000 limit, dont double amount.
                    if($goal != $totalgoal){ //if being matched
                            $tally = ($tally*2);
                    }else{
                        $tally = $tally;
                    }
            }else{
                    $tally = ($tally+$goal);
                };
*/



	    $remaining = ($totalgoal - $tally);
        $funding_percentage = 1;
        if ( $remaining <= 0 ) {
            //$funding_percentage = 1;
            $over = true;
             $diff = ($tally-$totalgoal);
            // $diff =  ( 100 * $diff );
             //var_dump($diff);
            //$funding_percentage = 100;
            //$funding_percentage = ($totalgoal / $tally );
        } else if ( $tally < $totalgoal ) {

            $funding_percentage = ( intval($tally) / $totalgoal);
        }
        $goal_length = intval( ( 100 * $funding_percentage ) );



//echo  $a->diff($b);
//echo get_post_meta($download_id, '_edd_purchase_limit_end_date', true );
$date_diff=(strtotime(get_post_meta($download_id, '_edd_purchase_limit_end_date', true ))-strtotime(date("Y-m-d H:i:s"))) / 86400;
//var_dump($diff);
//var_dump($totalgoal);

    ?>

		<style>
			.edd_cp_price{
				width: 200px!important;
			}

			.panel-default {
		    border-color: #dddddd;
		    background: #be202e;
		    color: #FFF;
		}

		.panel-default h3{
			    font-weight: bold;
			        font-size: 22px;
			        margin-bottom: 0px;
		}
		.panel-default h3 span{
			    font-weight: 300;
		}
		</style>

		<div class="row clearfix">
			<div class="col-sm-6">
				<?php echo edd_get_purchase_link( array( 'download_id' => $download_id ,'price' => false, 'direct'=> true, 'text' => 'Support') ); ?>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
				<div class="panel-body">
					<h3><sup>$</sup><?php echo number_format($tally, 0, '.', ','); ?> <span>Raised out of </span><sup>$</sup><?php echo $goal; ?></h3>
					<ul class="list-unstyled"><li><span class="cw-icon-user"></span><strong><?php echo $total_sales ; ?></strong> people supported Lifesongs</li><li><span class="cw-icon-alarmclock"></span><strong><?php echo intval($date_diff); ?></strong> days left to donate</li></ul><div class="visual"><div class="row clearfix"><div class="col-xs-6">100<?php //echo $goal_length; ?>%</div><div class="col-xs-6 text-right"><!-- $<?php echo $tally; ?> --></div></div><div class="bar"><div class="fill" style="width:54%;"></div></div></div>
			    	<div class="progress">
			                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo  $goal_length; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $goal_length; ?>%">
							</div>
			        </div>
				</div>
				</div>
			</div>
		</div>





	</div><!-- .entry-content -->
</article><!-- #post-## -->
	<?php endwhile; // end of the loop. ?>




		</div>
<?php get_footer(); ?>