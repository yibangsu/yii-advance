<?php

namespace frontend\models\company;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\company\Company;
use frontend\models\userInfo\UserInfo;

/**
 * CompanySearch represents the model behind the search form of `frontend\models\company\Company`.
 */
class CompanySearch extends Company
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_id'], 'integer'],
            [['c_name', 'c_site', 'c_desc'], 'safe'],
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
        $query = Company::find();

        // add conditions that should always apply here
        $id = Yii::$app->user->id;
        $userInfo = UserInfo::find()->where(['id' => $id, 'enable' => 'Y'])->one();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() || $userInfo === null) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // select the company with user info
        $query->where(['c_id' => $userInfo->company_id]);

        // grid filtering conditions
        $query->andFilterWhere([
            'c_id' => $this->c_id,
        ]);

        $query->andFilterWhere(['like', 'c_name', $this->c_name])
            ->andFilterWhere(['like', 'c_site', $this->c_site])
            ->andFilterWhere(['like', 'c_desc', $this->c_desc]);

        return $dataProvider;
    }
}
