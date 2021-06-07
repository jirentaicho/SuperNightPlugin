<?php

require_once dirname( __FILE__ ) . '/../../Utility/HelperUtility.php';
// プラグイン有効のときのみ
if(HelperUtility::isActivePostie()){
    require_once(WP_PLUGIN_DIR . '/postie/postie-api.php');
}

/**
 * カスタムフィールドの追加に必要なもの
 * admin_menuにadd_meta_box
 * save_post
 */
class AddCastCustomField{
    public function __construct(){

        // カスタムフィールドの設置
        add_action('admin_menu', array($this,'add_cast_fields'));
        // カスタムフィールドの値の保存
        add_action('save_post', array($this,'save_cast_fields'));
        // エディタは不要なので削除する
        // 無名関数で
        add_action( 'init', function() { 
            remove_post_type_support( 'cast', 'editor' ); 
        }, 99);

        // jsファイルの有効か
        add_action('admin_enqueue_scripts',array($this,'add_js_file'));
        add_action('admin_enqueue_scripts',function(){
            wp_enqueue_media();
        });

        // 削除時
        // add_action('wp_trash_post', 'function_name' );

        /**
         * 独自アクションの登録
         */
        add_action('update_postie',array($this,'update_postie_config'),10,1);
        add_action('delete_postie',array($this,'delete_postie_config'),10,1);
        
    }

    public function add_cast_fields(){
        add_meta_box( 'cast_setting', 'キャストの基本情報', array($this,'insert_cast_fields'), 'cast', 'normal');
    }

    /**
     *  HTMLを表示する
     */
    public function insert_cast_fields(){

        global $post;

        wp_nonce_field('cast_action','cast_nonce');
        echo '<label>キャスト名</label><br />';
        echo '<input type="text" name="cast_name" value="'.get_post_meta($post->ID, 'cast_name', true).'" size="50" /><br>';

        echo '<label>年齢</label><br />';
        echo '<input type="number" name="cast_age" value="'.get_post_meta($post->ID, 'cast_age', true).'" size="10" min="0" /><br>';
        
        $ch = get_post_meta($post->ID,'cast_isnew',true) ;
        echo '<label>新人</label><br />';
        ?>

        <input type="checkbox" name="cast_isnew" value="1" <?php checked(1, get_post_meta($post->ID,'cast_isnew',true), true); ?> />

        <?php
        echo '<br />';
        
        echo '<label>メールアドレス</label><br />';
        echo '<input type="email" name="cast_email" value="'.get_post_meta($post->ID, 'cast_email', true).'" size="10" min="0" /><br>';


        $main_image = get_post_meta($post->ID, 'main_image', true);
        echo '<P>キャスト画像</P>';
        echo '<input type="button" value="画像を選択" onclick="selectImage(\'main_image_area\',\'main_image_preview\')"/>';
        echo '<input type="button" class="deletebtn" value="画像を削除" onclick="delteImage(\'main_image_area\',\'main_image_preview\')"/>';
        echo '<input type="hidden" name="main_image" id="main_image_area" value="' . $main_image . '"/>';
        echo '<div id="main_image_preview">' . wp_get_attachment_image($main_image, 'small') . '</div>';

    }

    /**
     * カスタムフィールドの値を保存する処理
     * @param $post_id 投稿id
     */
    public function save_cast_fields($post_id) {

        // WPのセキュリティ対策
        if(isset($_POST['cast_nonce']) && $_POST['cast_nonce']){
            if(check_admin_referer('cast_action','cast_nonce')){
                //エラーチェックがあれば行う（今回は値が無ければ削除するので特になし）
                // $error = new WP_Error();

                if(!empty($_POST['cast_name'])){
                    update_post_meta($post_id, 'cast_name', $_POST['cast_name'] );
                }else{
                    delete_post_meta($post_id, 'cast_name');
                }
        
                if(!empty($_POST['cast_price'])){
                    update_post_meta($post_id, 'cast_price', $_POST['cast_price'] );
                }else{
                    delete_post_meta($post_id, 'cast_price');
                }

                if(!empty($_POST['cast_age'])){
                    update_post_meta($post_id, 'cast_age', $_POST['cast_age'] );
                }else{
                    delete_post_meta($post_id, 'cast_age');
                }

                if(!empty($_POST['cast_isnew'])){
                    update_post_meta($post_id, 'cast_isnew', $_POST['cast_isnew'] );
                }else{
                    delete_post_meta($post_id, 'cast_isnew');
                }

                /**
                 * メールアドレス
                 */
                if(!empty($_POST['cast_email'])){
                    update_post_meta($post_id, 'cast_email', $_POST['cast_email'] );
                    do_action('update_postie',$_POST['cast_email']);

                }else{
                    $email = get_post_meta($post_id,'cast_email',true);
                    delete_post_meta($post_id, 'cast_email');
                    do_action('delete_postie',$email);
                }
        
                if(!empty($_POST['main_image'])){
                    update_post_meta($post_id, 'main_image', $_POST['main_image'] );  
                }else{
                    delete_post_meta($post_id, 'main_image');
                }

                // スケジュールが空なら初期化する（最初の一回とスケジュールが空の場合のみ
                $schedule = get_post_meta($post_id,'myschedule',true);
                if(empty($schedule)){
                    $schedule = array();
                    update_post_meta($post_id, 'myschedule', $schedule );
                }

            }
        }

    }

    /**
     * jsファイルの有効化
     * plugins_url()でプラグインフォルダのパスを取得
     */
    function add_js_file($hook_suffix){
        global $post_type;
        if($post_type == 'cast' && in_array($hook_suffix,array('post.php','post-new.php'))){
            wp_enqueue_script('imageloader-script',plugins_url() . '/my-first-plugin/js/imageloader.js');
        }
    }



    /**
     * emailのバリデーションを行います。
     * @param $email 入力されたメールアドレス
     */
    public function validationEmail($email){
        
    }



    /**
     * postieの情報を更新します。
     * @param inputAddress 入力メールアドレス
     */
    public function update_postie_config($inputAddress){   
        if(!HelperUtility::isActivePostie()){
            return;
        }
        // config情報を取得する
        $postIeConf = postie_config_read();
        // email情報を追加する
        array_push($postIeConf["authorized_addresses"],$inputAddress);
        // 保存する
        update_option('postie-settings', $postIeConf);
    }


    /**
     * ユーザーのメールアドレスを、postieから削除します。
     * @param deleteAddress 削除するメールアドレス
     */
    public function delete_postie_config($deleteAddress){
        if(!HelperUtility::isActivePostie()){
            return;
        }
        // config情報を取得する
        $postIeConf = postie_config_read();
        // 同じメールアドレスが入っているかどうか
        $index = array_search($deleteAddress,$postIeConf["authorized_addresses"]);
        if(!$index){
            return;
        }
        array_splice($postIeConf["authorized_addresses"],$index);
        // 更新する
        update_option('postie-settings', $postIeConf);
    }


}