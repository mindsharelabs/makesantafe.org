<?php
$id = get_the_id();
$reserved_times = get_post_meta( $id, 'reserved_times', true);
$days_available = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday');

//
// function weekRange($weeks_in_advance = 4) {
//   $weeks = array();
//   $start_date = new DateTime();
//   $day_of_week = $start_date->format("w");
//   $start_of_current_week = $start_date->modify("-$day_of_week day");
//   $weeks[] = $start_of_current_week->format('Y-m-d');
//
//   for($i = 0; $i < $weeks_in_advance; $i++){
//     $start_of_week = $start_date->modify("+1 week")->modify("-$day_of_week day");
//     $weeks[] = $start_of_week->format('Y-m-d');
//   }
//   return $weeks;
// }
//
//
// function hoursRange( $lower = 0, $upper = 86400, $step = 900, $week_advance = 0) {
//     $times = array();
//
//     if ( empty( $format ) ) {
//         $format = 'g:i a';
//     }
//
//     foreach ( range( $lower, $upper, $step ) as $key => $increment ) {
//         $increment = gmdate( 'H:i', $increment );
//         list( $hour, $minutes ) = explode( ':', $increment );
//         $date = new DateTime( $hour . ':' . $minutes );
//         $times[$key] = $date->modify('+' . $week_advance . 'weeks');
//     }
//     return $times;
// }
// $week_range = weekRange(3);
// ?>
// <nav>
//   <div class="nav nav-tabs" id="nav-tab" role="tablist">
//     <?php
//     foreach ($week_range as $key => $date) :
//
//       if($key == 0){
//         $class = 'active';
//       } else {
//         $class = '';
//       }
//       echo '<a class="nav-item nav-link ' . $class . '" id="nav-' . $key . '-tab" data-toggle="tab" href="#nav_' . $key . '">Week of ' . $date . '</a>';
//     endforeach;
//     ?>
//   </div>
// </nav>
//
// <?php
// echo '<div class="tab-content" id="nav-tabContent">';
//   foreach ($week_range as $key => $date) :
//     // Every 30 Minutes from 12 PM - 8 PM
//     $range = hoursRange( 43200, 72000, 60 * 30, $key);
//     if($key == 0){
//       $class = 'active';
//     } else {
//       $class = '';
//     }
//     echo '<div class="tab-pane fade show ' . $class . '" id="nav_' . $key .'" role="tabpanel">';
//       echo '<div class="table-responsive">';
//         echo '<table class="table table-sm table-bordered text-center">';
//           echo '<thead>';
//             echo '<tr>';
//             foreach($days_available as $day):
//               echo '<th scope="col">' . $day . '</th>';
//             endforeach;
//             echo '</tr>';
//           echo '</thead>';
//           echo '<tbody>';
//         foreach ($range as $key => $time) :
//             echo '<tr>';
//             foreach ($days_available as $key => $day) :
//               $cell_time = $time->modify('+1 days');
//               echo '<th scope="row" data-time="' . $cell_time->format('Y-m-d H:i:s') . '">' .  $cell_time->format('l, M j') . '</th>';
//             endforeach;
//             echo '</tr>';
//         endforeach;
//           echo '</tbody>';
//         echo '</table>';
//       echo '</div>';
//
//     echo '</div>';
//   endforeach;
//
// echo '</div>';
