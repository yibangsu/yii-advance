<?php

namespace frontend\models\forceUpgrade;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\forceUpgrade\ForceVersion;
use frontend\models\role\Role;

/**
 * ForceVersionSearch represents the model behind the search form of `frontend\models\forceUpgrade\ForceVersion`.
 */
class ForceVersionSearch extends ForceVersion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fv_id', 'fv_sw_id', 'fv_u_id', 'fv_puid'], 'integer'],
            [['fv_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        unset($this->fv_u_id);
        return $result;
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
        $query = ForceVersion::find();

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
            'fv_id' => $this->fv_id,
            'fv_sw_id' => $this->fv_sw_id,
            'fv_date' => $this->fv_date,
            'fv_u_id' => $this->fv_u_id,
            'fv_puid' => $this->fv_puid,
        ]);

        return $dataProvider;
    }

    public function removeAll()
    {
        if (Role::beAdmin()) {
            $datas = ForceVersion::findAll(['fv_puid' => $this->fv_puid]);
            foreach ($datas as $data) {
                $data->delete();
            }
        } else {
            $datas = SoftwarePublish::findAll(['fv_puid' => $this->fv_puid, 'fv_u_id' => $this->fv_u_id]);
            foreach ($datas as $data) {
                $data->delete();
            }
        }
    }
}
