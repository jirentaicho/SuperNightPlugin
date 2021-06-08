<?php

// 利用するファイルを読み込む
require_once dirname( __FILE__ ) . '/MyRegisterSchedule.php';

class MyAddSchedulePage{
    public function __construct(){

        if (!defined('ABSPATH')) {
            exit;
        }

        add_action('admin_menu',
            array($this,'add_admin_page'));

        // 保存に関するクラスを初期化する
        $post_item_page = new MyRegisterSchedule();
        
        // jsファイルの有効化
        add_action( 'admin_head-toplevel_page_custom_myschedule_page', array($this,'my_admin_script') );

        // ajax登録処理
        add_action('wp_ajax_register_ajax_data', array($this,'register_ajax_data'));

    }

    public function add_admin_page(){
        add_menu_page(
            'キャストスケジュール設定',
            'キャストスケジュール設定',
            'manage_options',
            'custom_myschedule_page',
            array($this,'custom_myschedule_page'),
            'dashicons-admin-generic',
            6);
    }

    public function custom_myschedule_page(){
        require dirname(__FILE__) . '/MyView.php';
    }

    public function my_admin_script() {
        wp_enqueue_script('myscript',plugins_url() . '/super-night-plugin/js/myscript.js');
        wp_enqueue_style('mystyle', plugins_url() . '/super-night-plugin/css/mystyle.css');
        //JavaScriptに渡す値の設定
        // args : [0]=handle [1]=name [2]=values
        wp_localize_script('myscript', 'ex_values', array(
            'admin_url' => esc_url(admin_url( 'admin-ajax.php', __FILE__ )),
            'nonce' => wp_create_nonce('get-schedule-nonce'),
        ));   
    }

    /**
     * データの登録　スケジュールデータを登録します。
     * js側からajax通信を行うレシーバーです。
     */
    public function register_ajax_data(){

        $nonce = $_POST["nonce"];
        $post_id = $_POST["post_id"];

        if(wp_verify_nonce($nonce,'get-schedule-nonce')){

            $schedule = array();
            $schedule[date("Y-m-d") . '_from'] = $_POST[date("Y-m-d") . '_from'];
            $schedule[date("Y-m-d") . '_to'] = $_POST[date("Y-m-d") . '_to'];
            
            $schedule[date("Y-m-d",strtotime("1 day")) . '_from'] = $_POST[date("Y-m-d",strtotime("1 day")) . '_from'];
            $schedule[date("Y-m-d",strtotime("1 day")) . '_to'] = $_POST[date("Y-m-d",strtotime("1 day")) . '_to'];

            $schedule[date("Y-m-d",strtotime("2 day")) . '_from'] = $_POST[date("Y-m-d",strtotime("2 day")) . '_from'];
            $schedule[date("Y-m-d",strtotime("2 day")) . '_to'] = $_POST[date("Y-m-d",strtotime("2 day")) . '_to'];
            
            $schedule[date("Y-m-d",strtotime("3 day")) . '_from'] = $_POST[date("Y-m-d",strtotime("3 day")) . '_from'];
            $schedule[date("Y-m-d",strtotime("3 day")) . '_to'] = $_POST[date("Y-m-d",strtotime("3 day")) . '_to'];
            
            $schedule[date("Y-m-d",strtotime("4 day")) . '_from'] = $_POST[date("Y-m-d",strtotime("4 day")) . '_from'];
            $schedule[date("Y-m-d",strtotime("4 day")) . '_to'] = $_POST[date("Y-m-d",strtotime("4 day")) . '_to'];

            $schedule[date("Y-m-d",strtotime("5 day")) . '_from'] = $_POST[date("Y-m-d",strtotime("5 day")) . '_from'];
            $schedule[date("Y-m-d",strtotime("5 day")) . '_to'] = $_POST[date("Y-m-d",strtotime("5 day")) . '_to'];
            
            $schedule[date("Y-m-d",strtotime("6 day")) . '_from'] = $_POST[date("Y-m-d",strtotime("6 day")) . '_from'];
            $schedule[date("Y-m-d",strtotime("6 day")) . '_to'] = $_POST[date("Y-m-d",strtotime("6 day")) . '_to'];

            update_post_meta($_POST["post_id"], 'myschedule', $schedule );

            $result = array(
                0 => array(
                  'message' => '正常に更新が完了しました。'
                ),
            );
            header("Content-type: application/json; charset=UTF-8");
            echo json_encode($result);
        } else {
            $result = array(
                0 => array(
                  'error' => 'エラーが発生しました。'
                ),
            );
            header("Content-type: application/json; charset=UTF-8");
            echo json_encode($result);

        }
        wp_die();
    }

}