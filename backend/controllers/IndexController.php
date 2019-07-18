<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\controllers;

use backend\models\Area;
use backend\models\Image;
use backend\models\Qrcode;
use backend\models\Video;
use backend\models\Wifi;
use yii\web\NotFoundHttpException;
use backend\models\User;
use common\controllers\BaseController;

/**
 * 首页控制器
 * Class IndexController
 *
 * @package backend\controllers
 * @author  wang
 */
class IndexController extends BaseController
{

    public $enableCsrfValidation = false;    //取消 Csrf 验证


    /**
     * 进入首页
     *
     * @return string
     * @author wang
     */
    public function actionWelcome()
    {


        //获取所有二维码数量
        $all_qrcodes = Qrcode::find()->count();
        //获取已绑定场所的二维码数量
        $user_qrcodes = Qrcode::find()->where(['NOT',['wifi_id'=>0]])->count();

        //剩余广告展示次数
        $image_times = Image::find()->where('status',1)->sum('times');
        $video_times = Video::find()->where('status',1)->sum('times');


        $user_id = \Yii::$app->user->identity->getId();
        $res = \Yii::$app->authManager->getRolesByUser($user_id);
        if (empty($res['超级管理员'])){
            $user_model = new User();
            $res = $user_model->childrenIdArray($user_id);
            //非超级管理员只统计自己的场所数量
            $wifi_count = Wifi::find()->where(['in', 'user_id', $res,])->count();
            $wifi_id = Wifi::find()->where(['in', 'user_id', $res,])->select('id')->asArray()->all();
            $wifi_id = array_column($wifi_id,'id');
            //非超级管理员只统计自己二维码的数量
            $qrcode_count = Qrcode::find()->where(['in', 'wifi_id', $wifi_id,])->count();
            //非超级管理员只统计自己二维码的扫码次数
            $qrcode_times = Qrcode::find()->where(['in', 'wifi_id', $wifi_id,])->sum('show_times');
        } else {
            //场所数量
            $wifi_count = Wifi::find()->count();
            //二维码的数量
            $qrcode_count = Qrcode::find()->count();
            //二维码的扫码次数
            $qrcode_times = Qrcode::find()->sum('show_times');
        }

        $res = Wifi::find()->groupBy('province')->select('province,sum(connect_times) AS connect_times')->orderBy('connect_times DESC')->asArray()->all();


        foreach ($res as $key=>$val) {
            $data[$key]['name'] = Area::getName($val['province']);
            $data[$key]['value'] = $val['connect_times'];
            $data[$key]['province'] = $val['province'];
        }

        return $this->render('welcome', [
            'data'=>$data,
            'all_qrcodes'=>$all_qrcodes,
            'user_qrcodes'=>$user_qrcodes,
            'image_times'=>$image_times,
            'video_times'=>$video_times,
            'wifi_count'=>$wifi_count,
            'qrcode_count'=>$qrcode_count,
            'qrcode_times'=>$qrcode_times,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的页面不存在。');
    }

    public function actionProvince(){
        $province = \Yii::$app->request->get('province');
        $name = \Yii::$app->request->get('name');
        $province_id = \Yii::$app->request->get('province_id');

        if (!empty($province_id)) {
            $res = Wifi::find()->groupBy('city')->select('city,sum(connect_times) AS connect_times')->orderBy('connect_times DESC')->where(['province'=>$province_id])->asArray()->all();

            foreach ($res as $key=>$val) {
                $data[$key]['name'] = Area::getName($val['city']);
                $data[$key]['value'] = $val['connect_times'];
            }

            return $this->render('province', [
                'province'=>$province,
                'province_name'=>$name,
                'data'=>$data,
            ]);
        }

        return $this->render('province', [
            'province'=>$province,
            'province_name'=>$name,
        ]);


    }
}

