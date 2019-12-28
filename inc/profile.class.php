<?php


class makeProfile {
  private $userID = '';

  //Options
  private $options = '';
  private $waiverURL = '';
  private $membershipURL = '';
  private $badgesURL = '';
  private $forumURL = '';
  private $workshopsURL = '';
  private $sharingURL = '';

  private $workshopCategory = '';

  //User Info
  private $certifications = '';

  public function __construct() {
    $this->userID = get_current_user_id();

    $this->options = get_option( 'makesf_support_settings' );

    $this->waiverURL = (isset($this->options['makesf_waiver_url']) ? $this->options['makesf_waiver_url'] : false);
    $this->membershipURL = (isset($this->options['makesf_membership_url']) ? $this->options['makesf_membership_url'] : false);
    $this->badgesURL = (isset($this->options['makesf_badges_url']) ? $this->options['makesf_badges_url'] : false);
    $this->forumURL = (isset($this->options['makesf_forum_url']) ? $this->options['makesf_forum_url'] : false);
    $this->workshopsURL = (isset($this->options['makesf_workshops_url']) ? $this->options['makesf_workshops_url'] : false);
    $this->sharingURL = (isset($this->options['makesf_share_url']) ? $this->options['makesf_share_url'] : false);

    $this->workshopCategory = (isset($this->options['makesf_workshop_category']) ? $this->options['makesf_workshop_category'] : false);



    add_action('woocommerce_before_my_account', array($this, 'display_account_steps'));
    add_action('woocommerce_account_dashboard', array($this, 'profile_progress'));


  }
  public static function get_instance() {
    if ( null === self::$instance ) {
      self::$instance = new self;
    }
    return self::$instance;
  }
  private function define( $name, $value ) {
    if ( ! defined( $name ) ) {
      define( $name, $value );
    }
  }




  public function display_account_steps() {
    echo 'working';
  }




  function profile_progress() {
    $maker_steps = $this->get_profile_steps();
    if($maker_steps) :
      $count = count($maker_steps);
      $max = 100/$count;
      echo '<div class="progress mt-3 mb-3">';
      foreach ($maker_steps as $key => $step) :
        echo $this->get_progress_bar($step['label'], $max, 0, $step['complete'], $step['link']);
      endforeach;
      echo '</div>';
    endif;
  }


  private function get_profile_steps() {
    return array(
      'membership' => array(
        'label' => 'Start your membership',
        'complete' => $this->has_membership(),
        'link' => $this->membershipURL
      ),
      'waiver' => array(
        'label' => 'Sign a safety waiver',
        'complete' => $this->has_waiver(),
        'link' => $this->waiverURL
      ),
      'badge' => array(
        'label' => 'Get a badge',
        'complete' => $this->has_badge(),
        'link' => $this->badgesURL
      ),
      'forum' => array(
        'label' => 'Post to the forum',
        'complete' => $this->has_forum(),
        'link' => $this->forumURL
      ),
      'workshop' => array(
        'label' => 'Take a workshop',
        'complete' => $this->has_workshop(),
        'link' => $this->workshopsURL
      ),
      'share' => array(
        'label' => 'Share your projects!',
        'complete' => $this->has_project(),
        'link' => $this->sharingURL
      ),
    );
  }


  private function has_membership(){
    // bail if Memberships isn't active
    if ( ! function_exists( 'wc_memberships' ) ) {
      return;
    }
    return wc_memberships_is_user_active_member($this->userID);
  }


  private function has_waiver(){
    // bail if Gravity Forms isn't active
    if (! class_exists ('GFAPI')) {
      return;
    }
    $form = new GFAPI();
    $search_criteria = array();
    $search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $this->userID );
    $entries = $form->get_entries( 27, $search_criteria);

    if(count($entries) > 0) {
      return true;
    } else {
      return false;
    }
  }
  private function has_badge(){
    $certs = get_user_meta($this->userID, 'certifications', true);
    if($certs) :
      return true;
    else :
      return false;
    endif;
  }
  private function has_forum(){
    $posts = get_posts(array(
      'post_type' => array('reply', 'topic'),
      'author' => $this->userID
    ));
    if(count($posts) > 0) :
      return true;
    else :
      return false;
    endif;
  }

  private function has_project(){
    return true;
  }

  function has_workshop() {
    $bought = false;

    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $this->userID,
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => 'wc-completed' // Only orders with status "completed"
    ));
    foreach ( $customer_orders as $customer_order ) {
      // Updated compatibility with WooCommerce 3+
      $order_id = method_exists( $customer_order, 'get_id' ) ? $customer_order->get_id() : $customer_order->id;
      $order = wc_get_order( $customer_order );

      // Iterating through each current customer products bought in the order
      foreach ($order->get_items() as $item) {
          // WC 3+ compatibility
          if ( version_compare( WC_VERSION, '3.0', '<' ) ) :
              $product_id = $item['product_id'];
          else :
              $product_id = $item->get_product_id();
          endif;

          $terms = get_the_terms( $product_id, 'product_cat' );
          foreach ($terms as $term) {
            if($this->workshopCategory == $term->slug) :
              $bought = true;
              break;
            endif;
          }
      }
    }
    // return "true" if one the specifics products have been bought before by customer
    return $bought;
  }



  private function get_progress_bar($label, $max, $min, $complete, $link) {
    $complete = ($complete) ? 'bg-success' : 'bg-danger';
    $return = '<div class="progress-bar progress-bar-striped ' . $complete . ' border-right" role="progressbar" style="width: ' . $max . '%" aria-valuenow="' . $max . '" aria-valuemin="' . $min . '" aria-valuemax="' . $max . '">';
      $return .= ($link) ? '<a class="text-white" href="' . $link . '">' : '';
        $return .= '<span>' . $label . '</span>';
      $return .= ($link) ? '<a href="' . $link . '">' : '';
    $return .= '</div>';
    return $return;
  }




}//end of class


add_action('init', 'makesf_start_er_up');
function makesf_start_er_up(){
  new makeProfile();
}
