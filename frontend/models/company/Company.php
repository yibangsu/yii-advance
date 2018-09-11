<?php

namespace frontend\models\company;

use Yii;

/**
 * This is the model class for table "Company".
 *
 * @property int $c_id
 * @property string $c_name
 * @property string $c_site
 * @property string $c_desc
 *
 * @property Project[] $projects
 * @property User[] $users
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_name', 'c_site'], 'required'],
            [['c_name'], 'string', 'max' => 64],
            [['c_site'], 'string', 'max' => 32],
            [['c_desc'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'c_id' => 'Company ID',
            'c_name' => 'Company Name',
            'c_site' => 'Company Site',
            'c_desc' => 'Company Descryption',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasProjects()
    {
        return $this->hasMany(Project::className(), ['pj_c_id' => 'c_id']);
    }

}
