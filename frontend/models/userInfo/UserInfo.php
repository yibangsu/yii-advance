<?php

namespace frontend\models\userInfo;

use Yii;

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
            'id' => 'ID',
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'enable' => 'Enable',
        ];
    }
}
