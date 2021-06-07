<?php
/**
 * プラグインで使えるヘルパー系のユーティリティです。
 */
class HelperUtility{

    public static function isLoginStatus(){
        if (is_admin()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Postieがアクティブかどうかを返します。
     * アクティブの時はtrue
     * アクティブでない時はfalse
     */
    public static function isActivePostie(){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if(is_plugin_active('postie/postie.php')){
            return true;
        }else{
            return false;
        }
    }


}