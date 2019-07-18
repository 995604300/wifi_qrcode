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
use backend\models\User;
use backend\models\UserSearch;
use backend\models\Dictionary;
use common\controllers\BaseController;

/**
 * 实现用户模型的CRUD操作
 * Class UserController
 *
 * @package backend\controllers
 */
class UserController extends BaseController
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
     * 列出所有用户模型。
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示单个用户模型。
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
     * 创建一个新的用户模型。
     * 如果创建成功，浏览器将被重定向到"view"页面。
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new User();


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
     * 更新现有的用户模型。
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
     * 禁用现有的用户模型。
     * 如果禁用成功，浏览器将被重定向到"index"页面。
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->status == \common\models\User::STATUS_ACTIVE) {
            $model->status = \common\models\User::STATUS_DELETED;    //冻结
        } else {
            $model->status = \common\models\User::STATUS_ACTIVE;    //开启
        }
        if ($model->save(false)) {
            Yii::$app->getSession()->setFlash('success', '操作成功！');
        } else {
            Yii::$app->getSession()->setFlash('error', '操作失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * 根据主键值查找用户模型。
     * 如果找不到模型，将会抛出一个404 HTTP异常。
     *
     * @param integer $id
     * @return User 返回用户模型
     * @throws NotFoundHttpException 如果找不到模型
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的页面不存在。');
    }
}
