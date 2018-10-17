<?php

namespace frontend\models\software;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\software\Software;

/**
 * SoftwareSearch represents the model behind the search form of `frontend\models\software\Software`.
 */
class SoftwareSearch extends Software
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sw_id', 'sw_creator', 'sw_puid'], 'integer'],
            [['sw_ver', 'sw_release_note', 'sw_date'], 'safe'],
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
        $query = Software::find();

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

        $query->where(['sw_puid' => $this->sw_puid]);

        // grid filtering conditions
        $query->andFilterWhere([
            'sw_id' => $this->sw_id,
            'sw_creator' => $this->sw_creator,
            'sw_puid' => $this->sw_puid,
        ]);

        $query->andFilterWhere(['like', 'sw_ver', $this->sw_ver])
            ->andFilterWhere(['like', 'sw_release_note', $this->sw_release_note])
            ->andFilterWhere(['like', 'sw_date', $this->sw_date]);

        return $dataProvider;
    }
}
