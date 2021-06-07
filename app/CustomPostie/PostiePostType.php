<?php

$postiePostType = new PostiePostType;

class PostiePostType{

    public function __construct(){
        if (!defined('ABSPATH')) {
            exit;
        }
        add_action('init',array($this,'create_postie_post_type'));

    }
    /**
     * カスタム投稿タイプを追加する
     * これだけで独自の投稿タイプを作成できる
     */
    function create_postie_post_type() {
        register_post_type( 'mailpost', [
            'labels' => [
                'name'          => 'メール投稿', // configで変更したいけど
                'singular_name' => 'mailpost',
                'add_new_casr' => '追加',
                'add_new' => '追加',
            ],
            'public'        => true, 
            'has_archive'   => true,
            'menu_position' => 611,
            'show_in_rest'  => false, //不具合防止
            'supports' => array('custom-fields','title','editor') 
        ]);
    }
    
}