<?php

class makeMember {
  private $userID = '';


  public function __construct() {
    $this->userId = get_current_user_id();
    add_action('woocommerce_before_my_account', array($this, 'display_account_steps'));
    add_action('woocommerce_account_dashboard', array($this, 'profile_progress'));
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
          echo $this->get_progress_bar($step['label'], $max, 0, $step['complete']);
        endforeach;
      echo '</div>';
    endif;
  }


  private function get_profile_steps() {
    return array(
      'membership' => array(
        'label' => 'Start your membership',
        'complete' => $this->has_membership()
      ),
      'waiver' => array(
        'label' => 'Sign a safety waiver',
        'complete' => $this->has_waiver()
      ),
      'badge' => array(
        'label' => 'Get a badge',
        'complete' => $this->has_badge()
      ),
      'forum' => array(
        'label' => 'Post to the formum',
        'complete' => $this->has_forum()
      ),
      'workshop' => array(
        'label' => 'Take a workshop',
        'complete' => $this->has_workshop()
      ),
      'share' => array(
        'label' => 'Share your projects!',
        'complete' => $this->has_project()
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
    $search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $maker_id );
    $entries = $form->get_entries( 27, $search_criteria);

    if(count($entries) > 0) {
      return true;
    } else {
      return false;
    }
  }
  private function has_badge(){
    return false;
  }
  private function has_forum(){
    return true;
  }
  private function has_workshop(){
    return true;
  }
  private function has_project(){
    return true;
  }


  private function get_progress_bar($label, $max, $min, $complete) {
    $complete = ($complete) ? 'bg-success' : 'bg-danger';
    return '<div class="progress-bar progress-bar-striped ' . $complete . ' border-right" role="progressbar" style="width: ' . $max . '%" aria-valuenow="' . $max . '" aria-valuemin="' . $min . '" aria-valuemax="' . $max . '"><span>' . $label . '</span></div>';
  }


}//end of class


new makeMember();
