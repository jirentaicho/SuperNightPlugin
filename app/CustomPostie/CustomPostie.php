<?php

require_once dirname( __FILE__ ) . '/../Utility/HelperUtility.php';
// プラグイン有効のときのみ
if(HelperUtility::isActivePostie()){
    require_once(WP_PLUGIN_DIR . '/postie/postie-api.php');
}

/**
 * Postieのフィルターを呼び出して、
 * Postieの処理を拡張します。
 * カスタムフィールドへの登録は、登録後のアクションで行います。
 */
class CustomPostie{

    public function __construct(){

        // Postieが有効でない時は処理しない
        if(!HelperUtility::isActivePostie()){
            return;
        }

        //　投稿完了前のフィルター
        add_filter('postie_post_before', array($this,'postie_post_before_custom'), 10, 2);

        // 投稿完了後のフィルター
        add_action('postie_post_after', array($this,'postie_post_after_custom'));
    }

    /**
     * 投稿直前に、$postに$headersのメール情報を付与します。
     * @param $post 投稿配列
     * @param $headers ヘッダー情報
     */
    public function postie_post_before_custom($post, $headers){
        $email_info = $headers["from"]["mailbox"] . "@" . $headers["from"]["host"];
        $post["email_info"] = $email_info;
        return $post;
    }

    /**
     * 投稿直後にカスタムフィールドのemail情報を設定します。
     * @param $post メールアドレス情報が付与された投稿配列
     */
    public function postie_post_after_custom($post){
        $email_info = $post["email_info"];
        add_post_meta($post['ID'], 'user_email', $email_info, 0);
    }

}