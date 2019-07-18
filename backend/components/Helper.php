<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\components;

use backend\models\Log;
use Yii;

/**
 * 静态公共函数类库
 * Class Helper
 *
 * @package backend\components
 */
class Helper
{


    //历史访客数
    public static function getHistoryVisNum()
    {
        $res = Log::find()->count();

        return $res;
    }

    //最近一个月访问量
    public static function getMonthHistoryVisNum()
    {
        $LastMonth = strtotime("-1 month");
        $res = Log::find()->where(['>', 'created_at', $LastMonth])->count();

        return $res;
    }

    /**
     * @param        $string  字符串
     * @param        $length  字符串长度
     * @param string $etc     结尾字符
     * @return string 省略后字符串
     *                        显示部分字符串功能
     */
    public static function truncate_utf8_string($string, $length, $etc = '...')
    {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen) {
            $result .= $etc;
        }
        return $result;
    }

}