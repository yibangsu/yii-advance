<?php

namespace frontend\models\publish;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\publish\SoftwarePublish;

/**
 * SoftwarePublishSearch represents the model behind the search form of `frontend\models\publish\SoftwarePublish`.
 */
class SoftwarePublishSearch extends SoftwarePublish
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sp_id', 'sp_sw_id', 'sp_file_count', 'sp_publisher'], 'integer'],
            [['sp_date'], 'safe'],
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
        $query = SoftwarePublish::find();

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

        

        // grid filtering conditions
        $query->andFilterWhere([
            'sp_id' => $this->sp_id,
            'sp_sw_id' => $this->sp_sw_id,
            'sp_file_count' => $this->sp_file_count,
            'sp_date' => $this->sp_date,
            'sp_puid' => $this->sp_puid,
            'sp_publisher' => $this->sp_publisher,
        ]);

        return $dataProvider;
    }

    public function removeAll()
    {
        $datas = SoftwarePublish::findAll(['sp_puid' => $this->sp_puid, 'sp_publisher' => $this->sp_publisher]);
        foreach ($datas as $data) {
            $data->delete();
        }
    }
}
