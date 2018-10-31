<?php

namespace mdm\admin\models\OperationRecord;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * OperationRecordSearch represents the model behind the search form of `backend\models\OperationRecord\OperationRecord`.
 */
class OperationRecordSearch extends OperationRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['or_id', 'or_u_id', 'or_table_item_id'], 'integer'],
            [['or_table_name', 'or_table_item_name', 'or_table_action', 'or_date', 'username'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OperationRecord::find();

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

        $query->addSelect(OperationRecord::tableName().'.*')
              
              ->leftJoin(User::tableName(), User::tableName().'.`id` = `'.OperationRecord::tableName().'`.`or_u_id`')
              ->addSelect(User::tableName().'.username');

        // grid filtering conditions
        $query->andFilterWhere([
            'or_id' => $this->or_id,
            'or_u_id' => $this->or_u_id,
            'or_table_item_id' => $this->or_table_item_id,
            'or_date' => $this->or_date,
        ]);

        $query->andFilterWhere(['like', 'or_table_name', $this->or_table_name])
            ->andFilterWhere(['like', 'or_table_item_name', $this->or_table_item_name])
            ->andFilterWhere(['like', 'or_table_action', $this->or_table_action])
            ->andFilterWhere(['like', User::tableName().'.username', $this->username]);

        return $dataProvider;
    }
}
