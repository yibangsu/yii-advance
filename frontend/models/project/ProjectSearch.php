<?php

namespace frontend\models\project;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\project\Project;

/**
 * ProjectSearch represents the model behind the search form of `frontend\models\project\Project`.
 */
class ProjectSearch extends Project
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pj_id', 'pj_c_id'], 'integer'],
            [['pj_name', 'pj_desc'], 'safe'],
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
        $query = Project::find();

        // add conditions that should always apply here
        $userCompanyId = Yii::$app->user->getUserCompanyId();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() || !$userCompanyId) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['pj_c_id' => $userCompanyId]);

        // grid filtering conditions
        $query->andFilterWhere([
            'pj_id' => $this->pj_id,
            'pj_c_id' => $this->pj_c_id,
        ]);

        $query->andFilterWhere(['like', 'pj_name', $this->pj_name])
            ->andFilterWhere(['like', 'pj_desc', $this->pj_desc]);

        return $dataProvider;
    }
}
