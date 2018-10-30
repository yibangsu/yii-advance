<?php

namespace frontend\models\fotaSrc;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\fotaSrc\FileExtend;

use frontend\models\software\Software;

/**
 * FotaSearch represents the model behind the search form of `frontend\models\fotaSrc\FileExtend`.
 */
class FotaSearch extends FileExtend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fe_id', 'fe_fb_id', 'fe_from_ver', 'fe_to_ver'], 'integer'],
            [['sourceVersion', 'targetVersion', 'fb_name'], 'string'],
            [['fe_checksum', 'fe_release_note'], 'safe'],
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
        $query = FileExtend::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() || !$this->fe_puid) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['fe_puid' => $this->fe_puid])
              ->addSelect(FileExtend::tableName().'.*')
              
              ->leftJoin(FileBase::tableName(), '`'.FileBase::tableName().'`'.'.`fb_id` = `'.FileExtend::tableName().'`.`fe_fb_id`')
              ->addSelect(FileBase::tableName().'.fb_name')
              
              ->leftJoin(Software::tableName().' as source', '`source`.`sw_id` = `'.FileExtend::tableName().'`.`fe_from_ver`')
              ->addSelect('source.sw_ver as sourceVersion')
              
              ->leftJoin(Software::tableName().' as target', '`target`.`sw_id` = `'.FileExtend::tableName().'`.`fe_to_ver`')
              ->addSelect('target.sw_ver as targetVersion')
              ;

        // grid filtering conditions
        $query->andFilterWhere([
            'fe_id' => $this->fe_id,
            'fe_fb_id' => $this->fe_fb_id,
            'fe_from_ver' => $this->fe_from_ver,
            'fe_to_ver' => $this->fe_to_ver,
            'source.sw_ver' => $this->sourceVersion,
            'target.sw_ver' => $this->targetVersion,
            FileBase::tableName().'.fb_name' => $this->fb_name,
        ]);

        $query->andFilterWhere(['like', 'fe_release_note', $this->fe_release_note])
              ->andFilterWhere(['like', 'fe_checksum', $this->fe_checksum]);

        return $dataProvider;
    }

    /**
     * find one by Id
     *
     * @param string id, the primary key for table
     *
     * @return mixed instanceof frontend\models\fotaSrc\FileExtend
     */
    public function findOneById($id)
    {
        $dataProvider = $this->search(null);
        $query = $dataProvider->query;
        $query->andWhere('`fe_id`=\''.$id.'\'');

        return $query->one();
    }

}
