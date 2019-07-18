<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\controllers;

use backend\models\Advlog;
use backend\models\Image;
use backend\models\ImageSearch;
use backend\models\WifiAdvertisement;
use backend\models\WifiSearch;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\controllers\BaseController;
use yii\web\Request;
use yii\web\UploadedFile;

/**
 * 实现二维码模型的CRUD操作
 * Class QrcodeController
 *
 * @package backend\controllers
 */
class ImageController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * 列出所有二维码数据。
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示单个image模型。
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果找不到模型
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 创建一个新的Qrcode。
     * 如果创建成功，浏览器将被重定向到"view"页面。
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Image();
        if (Yii::$app->request->isPost) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                WifiAdvertisement::wifiAdv($model,1); // 当前广告与wifi关联
                Yii::$app->getSession()->setFlash('success', '创建成功！');
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', '创建失败！');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * 更新现有的Image模型。
     * 如果更新成功，浏览器将被重定向到"view"页面。
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果找不到模型
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                WifiAdvertisement::deleteAll(['adv_id'=>$model->id,'type'=>1]); //清除当前广告与wifi存在的关系
                WifiAdvertisement::wifiAdv($model,1);// 当前广告与wifi关联
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', '修改失败！');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 获取当前广告下的wifi数据。
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果找不到模型
     */
    public function actionPlus($id){
        $data = $this->findModel($id);

        return $this->render('plus', [
            'model' => $data->wifi,
        ]);
    }

    /**
     * 删除现有的Image模型。
     * 如果删除成功，浏览器将被重定向到"index"页面。
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);


        if ($model->delete()) {
            WifiAdvertisement::deleteAll(['adv_id'=>$id,'type'=>1]); //清除当前广告与wifi存在的关系
            Yii::$app->getSession()->setFlash('success', '操作成功！');
        } else {
            Yii::$app->getSession()->setFlash('error', '操作失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * 广告状态审核
     * @return \yii\web\Response
     * author: Wang YX
     */
    public function actionCheck(){
        $data = Yii::$app->request->get();
        $res = Image::updateAll(['status'=>$data['status']],['id'=>$data['id']]);
        if($res){
            Yii::$app->getSession()->setFlash('success', '操作成功！');
        }else {
            Yii::$app->getSession()->setFlash('error', '操作失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * 当前广告观看日志列表展示。
     *
     * @return mixed
     */
    public function actionAdvlog($id){
        $query = Advlog::find();
        $pagination = new Pagination([
                                         'defaultPageSize' => 15,
                                         'totalCount' => $query->where(['adv_id'=>$id,'type'=>1])->count(),
                                     ]);

        $data = $query->orderBy('created_at desc')
                      ->where(['adv_id'=>$id,'type'=>1])
                      ->offset($pagination->offset)
                      ->limit($pagination->limit)
                      ->all();


        return $this->render('log', [
            'adv_id' => $id,
            'data' => $data,
            'pagination' => $pagination,
        ]);
    }

    /**
     * 根据主键值查找Image模型。
     * 如果找不到模型，将会抛出一个404 HTTP异常。
     *
     * @param integer $id
     * @return Qrcode 返回Qrcode模型
     * @throws NotFoundHttpException 如果找不到模型
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的页面不存在。');
    }
}
