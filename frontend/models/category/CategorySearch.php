<?php

namespace frontend\models\category;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\category\Category;

/**
 * CategorySearch represents the model behind the search form of `frontend\models\category\Category`.
 */
class CategorySearch extends Category
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cp_id', 'cp_pj_id'], 'integer'],
            [['cp_name'], 'safe'],
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
        $query = Category::find();

        // add conditions that should always apply here
        $projectId = Yii::$app->user->getUserCache('projectId');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() || !$projectId) {
            // uncomment the following line if you do not want to return any records when validation fails
            Yii::warning("herer");
            $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['cp_pj_id' => $projectId]);

        // grid filtering conditions
        $query->andFilterWhere([
            'cp_id' => $this->cp_id,
            'cp_pj_id' => $this->cp_pj_id,
        ]);

        $query->andFilterWhere(['like', 'cp_name', $this->cp_name]);

        return $dataProvider;
    }
}
