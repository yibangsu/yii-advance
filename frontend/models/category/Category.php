<?php

namespace frontend\models\category;

use Yii;
use frontend\models\project\Project;

/**
 * This is the model class for table "Category_Project".
 *
 * @property int $cp_id
 * @property string $cp_name
 * @property int $cp_pj_id
 *
 * @property Project $cpPj
 * @property ProductInfo[] $productInfos
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Category_Project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cp_pj_id'], 'required'],
            [['cp_pj_id'], 'integer'],
            [['cp_name'], 'string', 'max' => 20],
            [['cp_pj_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['cp_pj_id' => 'pj_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cp_id' => Yii::t('app', 'Category ID'),
            'cp_name' => Yii::t('app', 'Category Name'),
            'cp_pj_id' => Yii::t('app', 'Project ID'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        $this->cp_pj_id = Yii::$app->user->getUserCache('projectId');
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasProject()
    {
        return $this->hasOne(Project::className(), ['pj_id' => 'cp_pj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasProductInfos()
    {
        return $this->hasMany(ProductInfo::className(), ['pi_cp_id' => 'cp_id']);
    }
}
