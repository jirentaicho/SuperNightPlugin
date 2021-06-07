<?php
/**
 * Plugin Name: SuperNight
 * Plugin URI: https://github.com/jirentaicho/SuperNightPlugin
 * Description: 夜のお店のテーマを拡張するプラグインです。
 * Author: ジレン特攻隊長
 * Version: 1.0.0
 * Author URI: https://volkruss.com/
 * 
 * @package JirenSuperNigth
 */

require_once dirname( __FILE__ ) . '/app/my_schedule/MyAddSchedulePage.php';
require_once dirname( __FILE__ ) . '/app/CustomPost/Cast/AddCastPostType.php';
require_once dirname( __FILE__ ) . '/app/Utility/HelperUtility.php';
require_once dirname( __FILE__ ) . '/app/CustomPostie/CustomPostie.php';
require_once dirname( __FILE__ ) . '/app/CustomPostie/PostiePostType.php';
require_once dirname( __FILE__ ) . '/SuperNightApi.php';
/**
 * activateの設定を行う
 */
register_activation_hook( __FILE__, "activation" );
register_deactivation_hook( __FILE__, "deactivation" );

/**
 * プラグイン有効化した時に呼ばれる関数
 */
function activation() {
	// TODO
}

/**
 * プラグイン無効化した時に呼ばれる関数
 */
function deactivation() {
    // TODO 
}


class SuperNight{
    public function init(){
        if(HelperUtility::isLoginStatus()){
            $register_my_schedule = new MyAddSchedulePage();
            $customPostie = new CustomPostie();
        }

        add_action( 'after_setup_theme', function(){
            $api = new SuperNightApi();
            global $super_night_api;
            $super_night_api = $api;
        });
         
    }
}

$superNight = new SuperNight();
$superNight->init();

