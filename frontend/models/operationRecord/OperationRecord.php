<?php

namespace frontend\models\operationRecord;

use Yii;
use common\models\User;

/**
 * This is the model class for table "Operation_Record".
 *
 * @property int $or_id
 * @property int $or_u_id
 * @property string $or_table_name
 * @property int $or_table_item_id
 * @property string $or_table_item_name
 * @property string $or_table_action
 * @property string $or_date
 *
 * @property User $orU
 */
class OperationRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Operation_Record';
    }

    /**
     * {@inheritdoc}
     */
    public function attributes ()
    {
        $attributes = parent::attributes();
        $attributes[] = 'username';
        return $attributes;
    }

    /**
     * action type defination
     */
    const ACTION_ADD = 'add';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_DELETE_ALL = 'delete-all';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['or_u_id', 'or_table_name', 'or_table_item_id', 'or_table_item_name', 'or_table_action', 'or_date'], 'required'],
            [['or_u_id', 'or_table_item_id'], 'integer'],
            [['or_date'], 'safe'],
            [['or_table_name', 'or_table_action'], 'string', 'max' => 64],
            [['or_table_item_name'], 'string', 'max' => 255],
            [['or_u_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['or_u_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'or_id' => Yii::t('app', 'ID'),
            'or_u_id' => Yii::t('app', 'User ID'),
            'or_table_name' => Yii::t('app', 'Table Name'),
            'or_table_item_id' => Yii::t('app', 'Table Item ID'),
            'or_table_item_name' => Yii::t('app', 'Table Item Name'),
            'or_table_action' => Yii::t('app', 'Table Action'),
            'or_date' => Yii::t('app', 'Date'),
            'username' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return result
     */
    public static function record($tableName, $tableItemId, $tableItemName, $action)
    {
        $record = new OperationRecord();
        $record->or_u_id = Yii::$app->user->id;
        $record->or_table_name = $tableName;
        $record->or_table_item_id = $tableItemId;
        $record->or_table_item_name = $tableItemName;
        $record->or_table_action = $action;
        $record->or_date = date("Y-m-d h:i:s",time());

        return $record->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasUser()
    {
        return $this->hasOne(User::className(), ['id' => 'or_u_id']);
    }
}
