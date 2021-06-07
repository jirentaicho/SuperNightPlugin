<?php

require_once dirname( __FILE__ ) . '/AddCastCustomField.php';


$addCastPostType = new AddCastPostType;

class AddCastPostType{

    public function __construct(){
        if (!defined('ABSPATH')) {
            exit;
        }
        add_action('init',array($this,'create_item_post_type'));
        // カスタムフィールドを設定する
        $cust_field = new AddCastCustomField();

    }
    /**
     * カスタム投稿タイプを追加する
     * これだけで独自の投稿タイプを作成できる
     */
    function create_item_post_type() {
        register_post_type( 'cast', [
            'labels' => [
                'name'          => 'キャスト',
                'singular_name' => 'cast',
                'add_new_casr' => 'キャストを追加',
                'add_new' => '新規キャスト登録',
            ],
            //'rewrite'       => array( 'slug' => 'cast' ),
            'public'        => true, 
            'has_archive'   => true,
            'menu_position' => 610,
            'show_in_rest'  => true, //新エディタを利用するかどうか/今回はエディタごと消しますので関係ない
        ]);
    }

}