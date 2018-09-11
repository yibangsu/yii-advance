<?php

namespace frontend\models\project;

use Yii;
use frontend\models\company\Company;

/**
 * This is the model class for table "Project".
 *
 * @property int $pj_id
 * @property string $pj_name
 * @property string $pj_desc
 * @property int $pj_c_id
 *
 * @property CategoryProject[] $categoryProjects
 * @property Company $pjC
 * @property UserInfo[] $userInfos
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pj_name', 'pj_c_id'], 'required'],
            [['pj_c_id'], 'integer'],
            [['pj_name'], 'string', 'max' => 32],
            [['pj_desc'], 'string', 'max' => 200],
            [['pj_name'], 'unique'],
            [['pj_c_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['pj_c_id' => 'c_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pj_id' => 'Project ID',
            'pj_name' => 'Project Name',
            'pj_desc' => 'Project Descryption',
            'pj_c_id' => 'Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasCategories()
    {
        return $this->hasMany(CategoryProject::className(), ['cp_pj_id' => 'pj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasCompany()
    {
        return $this->hasOne(Company::className(), ['c_id' => 'pj_c_id']);
    }
}
