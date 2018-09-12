<?php

namespace frontend\models\publish;

use Yii;
use frontend\models\software\Software;

/**
 * This is the model class for table "Software_Publish".
 *
 * @property int $sp_id
 * @property int $sp_sw_id
 * @property int $sp_file_count
 * @property string $sp_date
 * @property int $sp_publisher
 *
 * @property Software $spSw
 */
class SoftwarePublish extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Software_Publish';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sp_id', 'sp_sw_id', 'sp_file_count', 'sp_date', 'sp_publisher'], 'required'],
            [['sp_id', 'sp_sw_id', 'sp_file_count', 'sp_publisher'], 'integer'],
            [['sp_date'], 'safe'],
            [['sp_id'], 'unique'],
            [['sp_sw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['sp_sw_id' => 'sw_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sp_id' => Yii::t('app', 'Sp ID'),
            'sp_sw_id' => Yii::t('app', 'Sp Sw ID'),
            'sp_file_count' => Yii::t('app', 'Sp File Count'),
            'sp_date' => Yii::t('app', 'Sp Date'),
            'sp_publisher' => Yii::t('app', 'Sp Publisher'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpSw()
    {
        return $this->hasOne(Software::className(), ['sw_id' => 'sp_sw_id']);
    }
}
