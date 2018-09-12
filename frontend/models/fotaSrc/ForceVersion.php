<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "Force_Version".
 *
 * @property int $fv_id
 * @property int $fv_sw_id
 * @property string $fv_date
 * @property int $fv_u_id
 *
 * @property Software $fvSw
 */
class ForceVersion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Force_Version';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fv_id', 'fv_sw_id', 'fv_date', 'fv_u_id'], 'required'],
            [['fv_id', 'fv_sw_id', 'fv_u_id'], 'integer'],
            [['fv_date'], 'safe'],
            [['fv_id'], 'unique'],
            [['fv_sw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fv_sw_id' => 'sw_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fv_id' => Yii::t('app', 'Fv ID'),
            'fv_sw_id' => Yii::t('app', 'Fv Sw ID'),
            'fv_date' => Yii::t('app', 'Fv Date'),
            'fv_u_id' => Yii::t('app', 'Fv U ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFvSw()
    {
        return $this->hasOne(Software::className(), ['sw_id' => 'fv_sw_id']);
    }
}
