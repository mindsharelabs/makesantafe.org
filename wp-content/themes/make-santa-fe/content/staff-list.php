




<?php  $the_staff = get_field('staff');
				if($the_staff){ ?>
			<aside class="widget">
		<div class="widget-header">
			<h3 class="widget-title">MAKE Team</h3>
			 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
				<div class="widget-content">
		<?php
			foreach($the_staff as $person):
			//var_dump($person); ?>
			<div class="person clearfix">
						<a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><img src="<?php echo get_wp_user_avatar_src( $person['ID'], 'thumbnail' ); ?>" width="65" height="65" class="alignleft img-thumbnail img-responsive img-circle" /></a>
							<h5 class="nomargin-bottom"><a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><?php echo $person["user_firstname"].' '.$person["user_lastname"]; ?></a></h5>
							<?php echo get_the_author_meta( 'title', $person['ID'] ); ?>

					</div>
		<?php endforeach; ?>
				</div>
			</aside>
		<?php } ?>


<?php  $the_board = get_field('the_board_users');
				if($the_board){ ?>
			<aside class="widget">
		<div class="widget-header">
			<h3 class="widget-title">The Board</h3>
			 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
				<div class="widget-content">
		<?php
			foreach($the_board as $person):
			//var_dump($person); ?>
			<div class="person clearfix">
						<a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><img src="<?php echo get_wp_user_avatar_src( $person['ID'], 'thumbnail' ); ?>" width="65" height="65" class="alignleft img-thumbnail img-responsive img-circle" /></a>
							<h5 class="nomargin-bottom"><a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><?php echo $person["user_firstname"].' '.$person["user_lastname"]; ?></a></h5>
							<?php echo get_the_author_meta( 'title', $person['ID'] ); ?>

					</div>
		<?php endforeach; ?>
				</div>
			</aside>
		<?php } ?>







