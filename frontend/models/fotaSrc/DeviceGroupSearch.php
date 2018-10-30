<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\fotaSrc\DeviceGroup;
use common\models\User;

/**
 * DeviceGroupSearch represents the model behind the search form of `frontend\models\fotaSrc\DeviceGroup`.
 */
class DeviceGroupSearch extends DeviceGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dg_id', 'dg_u_id'], 'integer'],
            [['dg_name', 'dg_date', 'creator'], 'safe'],
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
        $this->dg_u_id = null;
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
        $query = DeviceGroup::find();

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

        $query->where(['dg_puid' => $this->dg_puid])
              ->addSelect(DeviceGroup::tableName().'.*')

              ->leftJoin(User::tableName(), User::tableName().'.`id` = `'.DeviceGroup::tableName().'`.`dg_u_id`')
              ->addSelect(User::tableName().'.`username` as creator')
              ;

        // grid filtering conditions
        $query->andFilterWhere([
            'dg_id' => $this->dg_id,
            'dg_date' => $this->dg_date,
            'dg_u_id' => $this->dg_u_id,
        ]);

        $query->andFilterWhere(['like', 'dg_name', $this->dg_name])
              ->andFilterWhere(['like', User::tableName().'.`username`', $this->creator]);

        return $dataProvider;
    }
}
