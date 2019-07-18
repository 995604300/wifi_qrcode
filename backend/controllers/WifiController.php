<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\controllers;

use backend\models\Area;
use backend\models\WifiSearch;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Wifi;
use common\controllers\BaseController;
use yii\web\Response;

/**
 * 实现WIFI模型的CRUD操作
 * Class WifiController
 *
 * @package backend\controllers
 */
class WifiController extends BaseController
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
     * 列出所有wifi模型。
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WifiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示单个wifi模型。
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
     * 创建一个新的wifi模型。
     * 如果创建成功，浏览器将被重定向到"view"页面。
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wifi();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * 更新现有的wifi模型。
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
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * 配置wifi的video广告
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果找不到模型
     */
    public function actionSetVideo()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $videoId = Yii::$app->request->get('videoId');
        $wifiId = Yii::$app->request->get('wifiId');

        $count = Wifi::updateAll(['video_id'=>$videoId],['id'=>$wifiId]);
        if ($count > 0) {
            $res['code'] = 200;
            $res['message'] = '修改成功!';
        } else {
            $res['code'] = -1;
            $res['message'] = '修改失败!';
        }

        return $res;
    }

    public function actionGetSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Area::find()->andWhere(['parent_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['id'], 'name' => $account['name']];
                    if ($i == 0) {
                        $selected = $account['id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }


    /**
     * 配置wifi的image广告
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果找不到模型
     */
    public function actionSetImage()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $imageId = Yii::$app->request->get('imageId');
        $wifiId = Yii::$app->request->get('wifiId');

        $count = Wifi::updateAll(['image_id'=>$imageId],['id'=>$wifiId]);
        if ($count > 0) {
            $res['code'] = 200;
            $res['message'] = '修改成功!';
        } else {
            $res['code'] = -1;
            $res['message'] = '修改失败!';
        }

        return $res;
    }

    /**
     * 删除现有的wifi模型。
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
            Yii::$app->getSession()->setFlash('success', '操作成功！');
        } else {
            Yii::$app->getSession()->setFlash('error', '操作失败！');
        }
        return $this->redirect(['index']);
    }



    /**
     * 根据主键值查找wifi模型。
     * 如果找不到模型，将会抛出一个404 HTTP异常。
     *
     * @param integer $id
     * @return Wifi 返回Wifi模型
     * @throws NotFoundHttpException 如果找不到模型
     */
    protected function findModel($id)
    {
        if (($model = Wifi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的页面不存在。');
    }
}
