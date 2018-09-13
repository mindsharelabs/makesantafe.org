<?php  /*
		Template Name: Avatar Updater

		*/

get_header(); ?>

		 <?php


	$avatars = new WP_Query(array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'oderby' => 'meta_value_num',
        'order' => 'ASC',
		'post_status' => 'inherit',
        'post_mime_type' => 'image/jpeg,image/gif,image/jpg,image/png',
        'post_parent' => 0,
/*
        'meta_query' => array(
            array(
                'key' => 'logo_sort_order'
            )
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => 'logo'
            )
        )
*/
    ));

    while ( $avatars->have_posts() ) : $avatars->the_post();


$media_meta = wp_get_attachment_metadata( get_the_ID());
		if(strpos($media_meta["file"], 'avatar') == false )continue;
		$media_id = get_the_ID();
    	//mapi_var_dump($avatars->post->post_author);
    	//mapi_var_dump($media_meta);

    	$media_url = wp_get_attachment_url( $media_id  ); // Full path
		$media_name = basename( $media_url   ); // Just the file name

		$avatar_metadata=array(
			'avatar_url'=>$media_url,
			'avatar_filename'=>$media_name,
			'resource'=>$media_id ,
			'type'=> 'media'

		);
		if($avatars->post->post_author=='0')continue;
				$meta_data = get_user_meta($avatars->post->post_author, 'wp_user_avatar');

				if (!empty($meta_data) )continue;
				mapi_var_dump($meta_data);
		mapi_var_dump($avatars->post->post_author );
		mapi_var_dump($avatar_metadata);



		update_user_meta( $avatars->post->post_author, 'wp_user_avatar', $avatar_metadata );




    endwhile;wp_reset_postdata();

/*

function anagram_is_timestamp($timestamp)
{
	$check = (is_int($timestamp) OR is_float($timestamp))
		? $timestamp
		: (string) (int) $timestamp;
	return  ($check === $timestamp)
        	AND ( (int) $timestamp <=  PHP_INT_MAX)
        	AND ( (int) $timestamp >= ~PHP_INT_MAX);
}


$args = array (
	'post_type' => 'event',
	'posts_per_page' => -1,
	//'p' => 1944
);
$my_query = null;
$my_query = new WP_Query($args);

if ($my_query->have_posts() ) :  while ($my_query->have_posts()) : $my_query->the_post();


	if( have_rows('recurring_dates') ) {

		while( have_rows('recurring_dates') ) {
			the_row();
			//mapi_var_dump(get_sub_field('date')); // 07/11/2016 9:00 am
			//mapi_var_dump(get_sub_field('date',false));//raw 1468227600
			$saved_start_date = get_sub_field('date',false);
			$saved_end_date = get_sub_field('end_time',false);

			//if(anagram_is_timestamp($saved_start_date))update_sub_field('date', date( "Y-m-d H:i:s" ,$saved_start_date));
			//if(anagram_is_timestamp($saved_end_date))update_sub_field('end_time', date( "Y-m-d H:i:s" ,$saved_end_date));
			//if(anagram_is_timestamp($saved_date))mapi_var_dump(date( "Y-m-d H:i:s" ,get_sub_field('date',false))); // 2016-07-11 09:00:00


		}

	}

endwhile;endif;wp_reset_postdata();
*/ ?>


<?php get_footer(); ?>