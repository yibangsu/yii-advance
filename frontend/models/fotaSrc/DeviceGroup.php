<?php

namespace frontend\models\fotaSrc;

use Yii;
use common\models\User;

/**
 * This is the model class for table "Device_Group".
 *
 * @property int $dg_id
 * @property string $dg_name
 * @property string $dg_date
 * @property int $dg_u_id
 *
 * @property User $dgU
 */
class DeviceGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Device_Group';
    }

     /**
     * {@inheritdoc}
     */
    public function attributes ()
    {
        $attributes = parent::attributes();
        $attributes[] = 'creator';
        return $attributes;
    }

    //public $creator;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dg_name', 'dg_date', 'dg_u_id'], 'required'],
            [['dg_date'], 'safe'],
            [['dg_u_id'], 'integer'],
            [['dg_name'], 'string', 'max' => 64],
            [['dg_u_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['dg_u_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dg_id' => Yii::t('app', 'ID'),
            'dg_name' => Yii::t('app', 'Name'),
            'dg_date' => Yii::t('app', 'Date'),
            'dg_u_id' => Yii::t('app', 'Creator'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $creatorId = $this->dg_u_id;
        $result = parent::load($data, $formName);
        $this->dg_puid = Yii::$app->user->getUserCache('puidId');
        $this->dg_u_id = $creatorId === null? Yii::$app->user->id: $creatorId;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->dg_u_id === Yii::$app->user->id) {
            $this->dg_date = date("Y-m-d h:i:s",time());
            return parent::save($runValidation, $attributeNames);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        if ($this->dg_u_id === Yii::$app->user->id) {
            $this->dg_date = date("Y-m-d h:i:s",time());
            return parent::update($runValidation, $attributeNames);
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDgU()
    {
        return $this->hasOne(User::className(), ['id' => 'dg_u_id']);
    }
}
