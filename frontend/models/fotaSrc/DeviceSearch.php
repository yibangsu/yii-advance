<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\fotaSrc\Device;
use common\models\User;

/**
 * DeviceSearch represents the model behind the search form of `frontend\models\fotaSrc\Device`.
 */
class DeviceSearch extends Device
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_id', 'd_dg_id', 'd_u_id'], 'integer'],
            [['d_code', 'd_bind_ver', 'd_date', 'deviceGroupName', 'creator'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

     /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        parent::load($data, $formName);
        $this->d_u_id = null;
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
        $query = Device::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['d_puid' => $this->d_puid])
              ->addSelect(Device::tableName().'.*')
              
              ->leftJoin(User::tableName(), User::tableName().'.`id` = `'.Device::tableName().'`.`d_u_id`')
              ->addSelect(User::tableName().'.`username` as creator')

              ->leftJoin(DeviceGroup::tableName(), DeviceGroup::tableName().'.`dg_id` = `'.Device::tableName().'`.`d_dg_id`')
              ->addSelect(DeviceGroup::tableName().'.`dg_name` as deviceGroupName')
              ;


        // grid filtering conditions
        $query->andFilterWhere([
            'd_id' => $this->d_id,
            'd_dg_id' => $this->d_dg_id,
            'd_date' => $this->d_date,
            'd_u_id' => $this->d_u_id,
        ]);

        $query->andFilterWhere(['like', 'd_code', $this->d_code])
            ->andFilterWhere(['like', 'd_bind_ver', $this->d_bind_ver])
            ->andFilterWhere(['like', DeviceGroup::tableName().'.`dg_name`', $this->deviceGroupName])
            ->andFilterWhere(['like', User::tableName().'.`username`', $this->creator]);

        return $dataProvider;
    }
}
