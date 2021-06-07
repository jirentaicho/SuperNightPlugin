<?php

require_once dirname( __FILE__ ) . '/app/Utility/ValueUtil.php';
/**
 * テーマ内から利用するSuperNightに関するAPIです。
 * 
 */
class SuperNightApi{

    /**
     * 全てのメール投稿された記事の配列取得します。<br />
     * get_postsを利用して取得した結果を返します。
     * 
     * @return $posts メール投稿された全ての記事の配列
     */
    public function getAllMailPost(){
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'mailpost',
          );
        $posts = get_posts( $args );
        return $posts;
    }

    /**
     * <P>キャストのメールアドレスをキーに、<br />
     * キャストのメール投稿された記事一覧配列を取得します。</P>
     * get_postsを利用して取得した結果を返します。
     * 
     * @param $email キャストのメールアドレス
     */
    public function getMailPostByMail($email){
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'mailpost',
            'meta_key' => 'user_email',
            'meta_value' => $email
          );
        $posts = get_posts( $args );
        return $posts;
    }

    /**
     * キャストの記事IDからキャストのメールアドレスを取得します。
     * 
     * @param $id キャストの記事ID
     */
    public function getCastEmail($id){
      return get_post_meta($id, 'cast_email', true);
    }

    /**
     * キャストの記事IDからキャストのカスタムフィールドの値を取得します。
     * 
     * @param $id キャストの記事ID
     * @return カスタムフィールドの配列
     */
    public function getCastField($id){
            
      $cast_name = get_post_meta($id, 'cast_name', true); 
      $cast_age = get_post_meta($id,'cast_age', true);
      $cast_isnew = get_post_meta($id,'cast_isnew', true);
      $cast_email = get_post_meta($id, 'cast_email', true);
      $cast_image = get_post_meta($id, 'main_image', true);
      $cast_schedule = get_post_meta($id, 'myschedule', true);
      
      return array(
        'name' => $cast_name, 
        'age' => $cast_age,
        'isNew' => $cast_isnew,
        'email' => $cast_email, 
        'image' => $cast_image, 
        'schedule' => $cast_schedule);
    }

    /**
     * キャストの記事IDから、キャストのメール投稿記事一覧を取得します。
     */
    public function getMailPostById($id){
      $email = get_post_meta($id, 'cast_email', true);
      $result = $this->getMailPostByMail($email);
      return $result;
    }

    /**
     * キャストの記事IDごとにスケジュールを取得します。
     * @param $id キャストの記事ID
     */
    public function getScheduleById($id){
      $cast_schedule = get_post_meta($post->ID, 'myschedule', true); 
      return $schedule;
    }

    /**
     * キャストの記事IDから、そのキャストのスケジュール情報の連想配列を取得します。
     * @param $id ID
     */
    public function getScheduleKey($id){

      $schedule = get_post_meta($id, 'myschedule', true);

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

      return array(
        'day_from' =>  $day_from,
        'day1_from' => $day1_from,
        'day2_from' => $day2_from,
        'day3_from' => $day3_from,
        'day4_from' => $day4_from,
        'day5_from' => $day5_from,
        'day6_from' => $day6_from,
        'day_to' =>  $day_to,
        'day1_to' => $day1_to,
        'day2_to' => $day2_to,
        'day3_to' => $day3_to,
        'day4_to' => $day4_to,
        'day5_to' => $day5_to,
        'day6_to' => $day6_to,
      );

    }


    /**
     * 出勤情報の文字列を取得します。
     * getScheduleKeyメソッドから取得した内容に基づいて引数を設定してください。
     * @param $index 日付index　当日は0 翌日は1
     * @param $from 出勤時刻from
     * @param $to 出勤時刻to
     */
    public function getScheduleString($index,$from,$to){

      $weekjp = array(
        '日',
        '月',
        '火',
        '水',
        '木',
        '金',
        '土'
      );
      
      return date("Y-m-d",strtotime($index . " day")) . '(' . $weekjp[date("w",strtotime($index . " day"))] . ')' . '　出勤時間：' . $from .'　〜　'. $to;
    }


    /**
     * APIの利用テストを行います。
     */
    public function superNightApiTest(){
      echo '<p>Api Called!</p>';
    }

}