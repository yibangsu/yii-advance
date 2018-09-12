<?php

namespace frontend\models\puid;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\puid\ProductInfo;

/**
 * ProductInfoSearch represents the model behind the search form of `frontend\models\puid\ProductInfo`.
 */
class ProductInfoSearch extends ProductInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pi_id', 'pi_cp_id', 'cp_used', 'pi_u_id'], 'integer'],
            [['PUID', 'pi_date'], 'safe'],
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
        $query = ProductInfo::find();

        // add conditions that should always apply here
        $CategoryId = Yii::$app->user->getUserCache('categoryId');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() || !$CategoryId) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['pi_cp_id' => $CategoryId]);

        // grid filtering conditions
        $query->andFilterWhere([
            'pi_id' => $this->pi_id,
            'pi_cp_id' => $this->pi_cp_id,
            'cp_used' => $this->cp_used,
            'pi_date' => $this->pi_date,
            'pi_u_id' => $this->pi_u_id,
        ]);

        $query->andFilterWhere(['like', 'PUID', $this->PUID]);

        return $dataProvider;
    }
}
