<?php
/**
 * プラグインで使える値のユーティリティです。
 */
class ValueUtil{


    public static function getSafeArrayValue($value,$array){
        if(array_key_exists($value,$array)){
            return $array[$value];
        }else{
            return "";
        }
    }

    public static function getScheduleHTML($index, $from, $to){
        $weekjp = array(
            '日',
            '月',
            '火',
            '水',
            '木',
            '金',
            '土'
        );
        return date("Y-m-d",strtotime($index . " day")) . '(' . $weekjp[date("w",strtotime($index . " day"))] . ')' . '　出勤時間： <input type="time" name="' . date("Y-m-d",strtotime($index . " day")) . '_from" value="'. $from .'" />　〜　<input type="time" name="' . date("Y-m-d",strtotime($index . " day")) . '_to" value="'. $to .'" /><br />';
    }

    public static function getSafeValue($value){
        if(is_null($value) || empty($value)){
            return "";
        } else {
            return $value;
        }
    }
}