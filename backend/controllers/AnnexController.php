<?php
/**
 * @author       wang wangyaxu7019@dingtalk.com
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\controllers;

use backend\models\BudgetOn;
use backend\models\Dictionary;
use backend\models\UploadForm;
use common\controllers\BaseController;
use Yii;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 15:52
 */
class AnnexController extends BaseController
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        $budgetOn = BudgetOn::findStartAll();    // 制表期数下拉框
        $area = Yii::$app->user->identity->area;    //登录人所属地区

        $get = Yii::$app->request->get();
        if (!empty($get['budgetNo'])) {
            $budgetNo = $get['budgetNo'];
            $pathXlsx = 'uploads/'.$budgetNo.'/'.$area.'.xlsx';
            $pathXls = 'uploads/'.$budgetNo.'/'.$area.'.xls';
            if (file_exists($pathXlsx)) {
                $path = Yii::$app->request->hostInfo.'/'.$pathXlsx;
                $pathinfo = "<a href=".$path." target='_blank'>".$budgetNo.$area."预算分摊模板</a><div style='margin-top: 20px;color:#23527C;'><i class='fa fa-check-square fa-2x'></i><label class='uploadInfo'>已上传</label></div>";
            } elseif (file_exists($pathXls)) {
                $path = Yii::$app->request->hostInfo.'/'.$pathXls;
                $pathinfo = "<a href=".$path." target='_blank'>".$budgetNo.$area."预算分摊模板</a><div style='margin-top: 20px;color:#23527C;'><i class='fa fa-check-square fa-2x'></i><label class='uploadInfo'>已上传</label></div>";
            } else {
                $pathinfo = '';
            }
        }
        return $this->render('index', [
            'budgetOn' => $budgetOn,
            'budgetNo' => $budgetNo,
            'pathinfo' => $pathinfo,

        ]);
    }


    /**上传文件
     *
     * @return array
     */
    public function actionFileUpload()
    {
        Yii::$app->response->format = 'json';

        $area = Yii::$app->user->identity->area;    // 获取所属地区
        $budgetNo = Yii::$app->request->post('budgetNo');    // 启动期数
        $this->delete($budgetNo, $area);    // 如果存在本月的附件，就删除

        /* 上传路径 */
        $rootPath = "uploads/";
        $pathinfo = pathinfo($_FILES["fileUpload"]["name"], PATHINFO_EXTENSION);    // 后缀
        $rootPaths = $rootPath.$budgetNo."/";
        if (!file_exists($rootPaths)) {
            mkdir($rootPaths, 0777);
        }
        $wnnex = $rootPaths.$area.'.'.$pathinfo;    //上传成功的路径
        $result = move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $wnnex);

        if ($result) {
            return ['code' => 200, 'msg' => '上传成功'];
        } else {
            return ['code' => 201, 'msg' => '上传失败'];
        }

    }


    /**公共删除方法
     *
     * @param $budgetNo 制表日期
     * @param $area     地区
     */
    public function delete($budgetNo, $area)
    {
        $pathXlsx = 'uploads/'.$budgetNo.'/'.$area.'.xlsx';
        $pathXls = 'uploads/'.$budgetNo.'/'.$area.'.xls';
        if (file_exists($pathXlsx)) {
            unlink($pathXlsx);
        } elseif (file_exists($pathXls)) {
            unlink($pathXls);
        } else {

        }
    }


    /**
     * 删除文件
     *
     * @return array
     */
    public function actionFileDelete()
    {
        Yii::$app->response->format = 'json';
        $budgetNo = Yii::$app->request->post('budgetNo');
        $area = Yii::$app->user->identity->area;
        $del = $this->delete($budgetNo, $area);
        return ['code' => 200];
    }

}