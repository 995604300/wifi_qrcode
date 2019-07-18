<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Dictionary;
use backend\models\DictionarySearch;
use common\controllers\BaseController;

/**
 * DictionaryController 实现 Dictionary 模型的 CRUD 操作
 * Class DictionaryController
 *
 * @package backend\controllers
 */
class DictionaryController extends BaseController
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
     * 列出所有字典模型。
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $type = Yii::$app->request->get('type');
        $searchModel = new DictionarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    /**
     * 显示单个字典模型。
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 创建一个新的字典模型。
     * 如果创建成功，浏览器将被重定向到"查看"页面。
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dictionary();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'type' => $model->type]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新现有的字典模型。
     * 如果更新成功，浏览器将被重定向到"查看"页面。
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'type' => $model->type]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除现有的字典模型。
     * 如果删除成功，浏览器将被重定向到"index"页面。
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'type' => Yii::$app->request->get('type')]);
    }

    /**
     * 根据主键值查找字典模型。
     * 如果找不到模型，将会抛出一个404 HTTP异常。
     *
     * @param integer $id
     * @return Dictionary 返回字典模型
     * @throws NotFoundHttpException 如果找不到模型
     */
    protected function findModel($id)
    {
        if (($model = Dictionary::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
