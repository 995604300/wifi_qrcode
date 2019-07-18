<?php
/**
 * @package    http://www.rulaiyun.cn/
 * @author     wang <wangyaxu7019@dingtalk.com>
 * @copyright  Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * WifiSearch represents the model behind the search form of `backend\models\Wifi`.
 */
class WifiSearch extends Wifi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [
                [
                    'name',
                    'describtion',
                    'province',
                    'city',
                    'area',
                    'address',
                    'SSID',
                    'sign',
                    'create_time',
                    'update_time',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Wifi::find();

        // add conditions that should always apply here
        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10;
        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                                   'sort' => ['defaultOrder' => ['id' => SORT_DESC]], // 新增配置项 默认 id 倒序
                                                   'pagination' => ['pageSize' => $pageSize],
                                               ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /*创建日期*/
        if (!empty($this->create_time)) {
            $createdDate = explode(' - ', $this->create_time);
            $createdAt = $createdDate[0];
            $createdAtEnd = $createdDate[1];
            $query->andWhere("create_time >= '$createdAt 00:00:00' AND create_time <= '$createdAtEnd 23:59:59'");
        }

        /*修改日期*/
        if (!empty($this->update_time)) {
            $updatedDate = explode(' - ', $this->update_time);
            $updatedAt = $updatedDate[0];
            $updatedAtEnd = $updatedDate[1];
            $query->andWhere("update_time >= '$updatedAt 00:00:00' AND update_time <= '$updatedAtEnd 23:59:59'");
        }

        /*省*/
        if (!empty($this->province)) {
            $res = Area::searchName($this->province,1);
            foreach ($res as $val) {
               $ids[] = ArrayHelper::getValue($val,'id');
            }
            if (!empty($ids)){
                $query->andFilterWhere(['in', 'province', $ids]);
            } else {
                $query->andFilterWhere(['id' => -1]);
            }
        }

        /*市*/
        if (!empty($this->city)) {
            $res = Area::searchName($this->city,2);
            foreach ($res as $val) {
                $ids[] = ArrayHelper::getValue($val,'id');
            }
            if (!empty($ids)){
                $query->andFilterWhere(['in', 'city', $ids]);
            } else {
                $query->andFilterWhere(['id' => -1]);
            }
        }

        /*县区*/
        if (!empty($this->area)) {
            $res = Area::searchName($this->area,3);
            foreach ($res as $val) {
                $ids[] = ArrayHelper::getValue($val,'id');
            }
            if (!empty($ids)) {
                $query->andFilterWhere(['in', 'area', $ids]);
            } else {
                $query->andFilterWhere(['id' => -1]);
            }
        }

        //非超级管理员只能查看自己的场所
        $user_id = \Yii::$app->user->identity->getId();
        $res = \Yii::$app->authManager->getRolesByUser($user_id);
        if (empty($res['超级管理员'])){
            $user_model = new User();
            $res = $user_model->childrenIdArray($user_id);
            $query->andFilterWhere(['in', 'rly_wifi.user_id', $res,]);
        }

        $query->andFilterWhere(['id' => $this->id,])
              ->andFilterWhere(['like', 'name', $this->name,])
              ->andFilterWhere(['like', 'describtion', $this->describtion,])
              ->andFilterWhere(['like', 'address', $this->address])
              ->andFilterWhere(['like', 'SSID', $this->SSID,])
              ->andFilterWhere(['like', 'sign', $this->sign]);

        return $dataProvider;
    }

}
