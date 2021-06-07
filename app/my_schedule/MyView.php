<?php
  require_once dirname( __FILE__ ) . '/../Utility/ValueUtil.php';
?>

<div class="wrap">


<div id="super-night-loading" class="super-night-close"><P>処理中です</P></div>

  
  <?php 
    $args = array(
      'posts_per_page' => -1 ,
      'post_type' => 'cast',
      'orderby' => 'modified',
      'order' => 'desc',
    );
    $posts = get_posts( $args );
  ?>

  <?php if(empty($posts)) : ?>
    <h1>キャストの登録をしてください</h1>
  <?php endif; ?>

  <?php
  foreach ( $posts as $post ):
    setup_postdata( $post );
    $cast_name = get_post_meta($post->ID, 'cast_name', true);
    $schedule = get_post_meta($post->ID, 'myschedule', true); 
  ?>
    <h1><?php echo $cast_name ?>さん</h1>

<?php

    if(!is_array($schedule)){
      echo "バグです";
      die();
    }

    $day_from = ValueUtil::getSafeArrayValue(date("Y-m-d") . "_from",$schedule);
    $day1_from = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("1 day")) . "_from",$schedule);
    $day2_from = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("2 day")) . "_from",$schedule);
    $day3_from = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("3 day")) . "_from",$schedule);
    $day4_from = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("4 day")) . "_from",$schedule);
    $day5_from = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("5 day")) . "_from",$schedule);
    $day6_from = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("6 day")) . "_from",$schedule);

    $day_to = ValueUtil::getSafeArrayValue(date("Y-m-d") . "_to",$schedule);
    $day1_to = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("1 day")) . "_to",$schedule);
    $day2_to = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("2 day")) . "_to",$schedule);
    $day3_to = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("3 day")) . "_to",$schedule);
    $day4_to = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("4 day")) . "_to",$schedule);
    $day5_to = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("5 day")) . "_to",$schedule);
    $day6_to = ValueUtil::getSafeArrayValue(date("Y-m-d",strtotime("6 day")) . "_to",$schedule);

    $new_schedule = array(
      $day_from,$day1_from,$day2_from,$day3_from,$day4_from,$day5_from,$day6_from,
      $day_to,$day1_to,$day2_to,$day3_to,$day4_to,$day5_to,$day6_to
    );

    
    // フォームの作成
    $index = 0;

    echo "<div class='schedule-area'>";
    
    wp_nonce_field( 'name_of_my_action','name_of_nonce_field' );

    echo '<div class="schedule-data">';
      echo '<input type="hidden" name="post_id" value=" ' . $post->ID . '" >';
      echo ValueUtil::getScheduleHTML($index++, $day_from, $day_to);
      echo ValueUtil::getScheduleHTML($index++, $day1_from, $day1_to);
      echo ValueUtil::getScheduleHTML($index++, $day2_from, $day2_to);
      echo ValueUtil::getScheduleHTML($index++, $day3_from, $day3_to);
      echo ValueUtil::getScheduleHTML($index++, $day4_from, $day4_to);
      echo ValueUtil::getScheduleHTML($index++, $day5_from, $day5_to);
      echo ValueUtil::getScheduleHTML($index++, $day6_from, $day6_to);
    echo '</div>';
    echo "<button class='save-button'>更新する</button>";

    echo "</div>";
?>
   
    
  <?php
    endforeach;
    wp_reset_postdata();
  ?>

</div>