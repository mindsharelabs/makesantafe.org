<?php

if(is_author()) :
    echo '<meta property="og:image" content="' . get_template_directory_uri() . '/" />';
endif;

if(is_post_type_archive( 'make_track' )) :
    echo '<meta property="og:image" content="' . get_template_directory_uri() . '/" />';
endif;



