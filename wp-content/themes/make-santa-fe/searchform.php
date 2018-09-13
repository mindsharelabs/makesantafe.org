<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
		<input type="text" required value="<?php echo get_search_query(); ?>" placeholder="Search..." name="s" id="s" />
		<input type="hidden" value="submit">
</form>