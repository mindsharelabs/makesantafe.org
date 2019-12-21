<?php


function make_build_img_srcset($src_sizes) {
  $available_sizes = get_intermediate_image_sizes();
  if($available_sizes) :
    $srcset = '';
    $src = '';
    foreach ($available_sizes as $key => $size) :
      $srcset .= $src_sizes[$size] . ' ' . $src_sizes[$size . '-width'] . 'w' . ((next($available_sizes)) ? ', ' : '');
    endforeach;
  endif;
  return $srcset;
}


function make_get_image_html($acf_image_array, $width = 500, $height = '', $srcset = true, $class = '') {
  if($srcset){
     $srcset_attr = 'srcset="' . make_build_img_srcset($acf_image_array['sizes']) . '"';
  } else {
    $srcset_attr = '';
  }
  if($acf_image_array['subtype'] == 'gif') {
    $img_html = '<img class="' . $class . '" alt="' . $acf_image_array['title'] . '" title="' . $acf_image_array['title'] . '" src="' . $acf_image_array['url'] . '">';
  } else {
    $img_src = aq_resize($acf_image_array['url'], $width, $height);
    $img_html = '<img class="' . $class . '" alt="' . $acf_image_array['title'] . '" title="' . $acf_image_array['title'] . '" ' . $srcset_attr . ' src="' . $img_src . '">';
  }
  return $img_html;
}
