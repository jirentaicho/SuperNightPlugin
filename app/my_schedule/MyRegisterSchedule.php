<?php

class MyRegisterSchedule{

    public function __construct(){
        add_action('admin_init',
            array($this,'myregister_schedule_setting'
        ));
    }

    public function myregister_schedule_setting(){

        register_setting(
            'myschedule_options_group',
            'myschedule_options',
            'mysanitize_schedule_options'
        );
    }

    public function mysanitize_myschedule_options(){
        $new_options = array();
        if ( isset( $options['test'] ) ) {
            $new_options['test'] = sanitize_text_field( $options['test'] );
        }
        // 結果を返却
        return $new_options;
    }

}
