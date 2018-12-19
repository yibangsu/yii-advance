<?php

namespace backend\models\UserInfo;

use Yii;
use frontend\models\company\Company;
use common\models\User;

/**
 * This is the model class for table "User_Info".
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string $enable
 *
 * @property User $user
 * @property Company $company
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributes ()
    {
        $attributes = parent::attributes();
        $attributes[] = 'userName';
        $attributes[] = 'companyName';
        return $attributes;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User_Info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'company_id'], 'required'],
            [['user_id', 'company_id'], 'integer'],
            [['enable'], 'string', 'max' => 1],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'c_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'enable' => Yii::t('app', 'Enable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['c_id' => 'company_id']);
    }
}
