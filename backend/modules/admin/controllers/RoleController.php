<?php

namespace mdm\admin\controllers;


use Yii;
use yii\rbac\Item;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\models\AuthItem;
use mdm\admin\components\Configs;
use mdm\admin\components\Helper;
use mdm\admin\models\searchs\AuthItem as AuthItemSearch;
/**
 * RoleController implements the CRUD actions for AuthItem model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class RoleController extends Controller
{

    public $type = Item::TYPE_ROLE;
    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'Item' => 'Role',
            'Items' => 'Roles',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_ROLE;
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
//                    'assign' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('/role/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param  string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('/role/view', ['model' => $model]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = $this->type;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['assign', 'id' => $model->name]);
        } else {
            return $this->render('/role/create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['assign', 'id' => $model->name]);
        }

        return $this->render('/role/update', ['model' => $model]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Configs::authManager()->remove($model->item);
        Helper::invalidate();

        return $this->redirect(['/admin/role/index']);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        if (Yii::$app->request->isPost) {
            $items = Yii::$app->getRequest()->post('items', []);
            $model = $this->findModel($id);
            $success = $model->addChildren($items);
            Yii::$app->getResponse()->format = 'json';

            return array_merge($model->getItems(), ['success' => $success]);
        } else {
            $model = $this->findModel($id);

            return $this->render('/role/assign', ['model' => $model]);
        }
    }

    /**
     * Assign or remove items
     * @param string $id
     * @return array
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->removeChildren($items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'item';
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $auth = Configs::authManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);
        if ($item) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('请求的页面不存在。');
        }
    }

    /**
     * 角色保存权限
     * @param string $id
     * @return array
     */
    public function actionSave($id)
    {
        Yii::$app->getResponse()->format = 'json';
        $model = $this->findModel($id);
        $add = Yii::$app->getRequest()->post('items', []);
        $manager = Configs::authManager();
        $remove = array_keys($manager->getPermissions());
        $model->removeChildren($remove);
        $success = $model->addChildren($add);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems(), ['success' => $success,'message' => '操作成功','code' => 1]);

    }
}
