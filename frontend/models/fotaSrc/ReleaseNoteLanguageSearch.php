<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\fotaSrc\ReleaseNoteLanguage;

/**
 * ReleaseNoteLanguageSearch represents the model behind the search form of `frontend\models\fotaSrc\ReleaseNoteLanguage`.
 */
class ReleaseNoteLanguageSearch extends ReleaseNoteLanguage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rnl_id'], 'integer'],
            [['rnl_tag', 'rnl_note'], 'safe'],
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
        $query = ReleaseNoteLanguage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'rnl_id' => $this->rnl_id,
        ]);

        $query->andFilterWhere(['like', 'rnl_tag', $this->rnl_tag])
            ->andFilterWhere(['like', 'rnl_note', $this->rnl_note]);

        return $dataProvider;
    }
}
