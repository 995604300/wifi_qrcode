<?php

namespace mdm\admin\components;

use Yii;
use mdm\admin\models\AuthItem;
use mdm\admin\models\searchs\AuthItem as AuthItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\NotSupportedException;
use yii\filters\VerbFilter;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 *
 * @property integer $type
 * @property array   $labels
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since  1.0
 * @author wang 修改更新、新建、删除三个方法
 */
class ItemController extends Controller
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
                    'delete' => ['get'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItem models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param  string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @author wang
     */
    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = $this->type;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            /* 进入页面，加载下拉树状结构 */
            $searchModel = new AuthItemSearch(['type' => $this->type]);
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            /* 获取数组 */
            $select = $dataProvider->getModels();
            return $this->render('create', [
                'model' => $model,
                'allmodel' => $select,
            ]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  string $id
     * @return mixed
     * @author wang
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }
        /* 进入页面，加载下拉树状结构 */
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        /* 获取数组 */
        $select = $dataProvider->getModels();
        return $this->render('update', ['model' => $model, 'allmodel' => $select,]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  string $id
     * @return mixed
     * @auther wang
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        /* 查询要删除用户当前是否存在下级 */
        $count = (new \yii\db\Query())->from('rly_auth_item')->where('parentid='.$model->getItem()->id)->count();

        /* 判断当有下级时 不给删除 */
        if ($count > 0) {
            $searchModel = new AuthItemSearch(['type' => $this->type]);
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            return $this->render('index', [
                'massage' => '不能删除含有下级的权限',
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        }

        /* 执行删除 */
        Configs::authManager()->remove($model->item);
        Helper::invalidate();

        return $this->redirect(['index']);
    }

    /**
     * Assign items
     *
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->addChildren($items);
        Yii::$app->getResponse()->format = 'json';
        $allItem = $model->getItems();
        foreach ($allItem['available'] as $key => $val) {
            if ($val != 'route') {
                unset($allItem['available'][$key]);
            }
        }
        return array_merge($allItem, ['success' => $success]);
    }

    /**
     * Assign or remove items
     *
     * @param string $id
     * @return array
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->removeChildren($items);
        Yii::$app->getResponse()->format = 'json';

        $allItem = $model->getItems();
        foreach ($allItem['available'] as $key => $val) {
            if ($val != 'route') {
                unset($allItem['available'][$key]);
            }
        }
        return array_merge($allItem, ['success' => $success]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return $this->module->getViewPath().DIRECTORY_SEPARATOR.'item';
    }

    /**
     * Label use in view
     *
     * @throws NotSupportedException
     */
    public function labels()
    {
        throw new NotSupportedException(get_class($this).' does not support labels().');
    }

    /**
     * Type of Auth Item.
     *
     * @return integer
     */
    public function getType()
    {

    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
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
}
