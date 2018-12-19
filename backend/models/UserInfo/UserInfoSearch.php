<?php

namespace backend\models\UserInfo;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserInfo\UserInfo;
use frontend\models\company\Company;
use common\models\User;

/**
 * UserInfoSearch represents the model behind the search form of `backend\models\UserInfo\UserInfo`.
 */
class UserInfoSearch extends UserInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'company_id'], 'integer'],
            [['enable', 'companyName', 'userName'], 'safe'],
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
        $query = UserInfo::find();

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

        $query->addSelect(UserInfo::tableName().'.*')

              ->leftJoin(Company::tableName(), '`'.Company::tableName().'`'.'.`c_id` = `'.UserInfo::tableName().'`.`company_id`')
              ->addSelect(Company::tableName().'.c_name as companyName')

              ->leftJoin(User::tableName(), User::tableName().'.`id` = `'.UserInfo::tableName().'`.`user_id`')
              ->addSelect(User::tableName().'.username as userName')
              ;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'enable', $this->enable])
              ->andFilterWhere(['like', 'userName', $this->userName])
              ->andFilterWhere(['like', 'companyName', $this->companyName]);

        return $dataProvider;
    }
}
