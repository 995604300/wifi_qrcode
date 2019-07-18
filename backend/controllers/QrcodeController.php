<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\controllers;

use backend\models\Qrcode;
use backend\models\QrcodeSearch;
use backend\models\User;
use GuzzleHttp\Client;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\controllers\BaseController;

/**
 * 实现二维码模型的CRUD操作
 * Class QrcodeController
 *
 * @package backend\controllers
 */
class QrcodeController extends BaseController
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
        $searchModel = new QrcodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Qrcode();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * 显示单个Qrcode模型。
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
        $data = Yii::$app->request->post('Qrcode');
        if (empty($data['user'])) {
            $data['user'] = 0;
        }
        if (empty($data['times'])) {
            Yii::$app->getSession()->setFlash('error', "请输入需要生成二维码的数量！");
        } else {
            $client = new Client();
            $i = 0;
            if (empty($data['times'])){
                $response = $client->request('POST','https://wifi.rulaiyun.cn/public/index.php/code',['form_params' => ['user'=>$data['user']]]);
                $code = $response->getStatusCode();
                $i = 1;
            }else {
                for ($k=0;$k<$data['times'];$k++){
                    $response = $client->request('POST','https://wifi.rulaiyun.cn/public/index.php/code',['form_params' => ['user'=>$data['user']]]);
                    $code = $response->getStatusCode();
                    if ($code == 200) {
                        $i++;
                    }
                }
            }
            if ($code == 200) {
                Yii::$app->getSession()->setFlash('success', "成功创建$i 个二维码！");
            } else {
                Yii::$app->getSession()->setFlash('error', '创建失败！');
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * 更新现有的Qrcode模型。
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
     * 展示选中的二维码
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShow()
    {
        $keys = Yii::$app->request->get('keys');
        $show_view = Yii::$app->request->get('model');
        $key = "rulaiyun";
        $iv = "2X3GCw78PsgKB5Ap";
        $key = md5($key);

        $encrypt_msg = base64_decode($keys);
        $encrypted = openssl_decrypt($encrypt_msg, 'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);


        $ids = explode(',',$encrypted);

        $data = Qrcode::find()->select('id,qrcode_path')->where(['in', 'id', $ids,])->asArray()->all();
        foreach ($data as $key=>$value) {
            $data[$key]['id'] = 'ID:'.str_pad($value['id'],12,0,STR_PAD_LEFT );
        }
        return $this->render('model'.$show_view, [
            'data' => $data,
        ]);
    }

    /**
     * 删除现有的Qrcode模型。
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
     * 根据主键值查找Qrcode模型。
     * 如果找不到模型，将会抛出一个404 HTTP异常。
     *
     * @param integer $id
     * @return Qrcode 返回Qrcode模型
     * @throws NotFoundHttpException 如果找不到模型
     */
    protected function findModel($id)
    {
        if (($model = Qrcode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的页面不存在。');
    }
}
