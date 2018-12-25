<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\fotaSrc\FileBase;

/**
 * FileBaseSearch represents the model behind the search form of `frontend\models\fotaSrc\FileBase`.
 */
class FileBaseSearch extends FileBase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fb_id', 'fb_status', 'fb_size'], 'integer'],
            [['fb_name', 'fb_path', 'fb_date', 'fb_server', 'fb_type'], 'safe'],
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
        $query = FileBase::find();

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

        // static filtering conditions
        $query->andFilterWhere(['like', 'fb_path', $this->fb_path]);
        $query->andFilterWhere(['like', 'fb_server', $this->fb_server]);

        // grid filtering conditions
        $query->andFilterWhere([
            'fb_id' => $this->fb_id,
            'fb_status' => $this->fb_status,
            'fb_date' => $this->fb_date,
            'fb_size' => $this->fb_size,
        ]);

        $query->andFilterWhere(['like', 'fb_name', $this->fb_name]);

        return $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        parent::load($data, $formName);
        unset($this->fb_server);
    }
}
