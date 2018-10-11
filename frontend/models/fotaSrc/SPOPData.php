<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "SPOP_Data".
 *
 * @property int $spop_data_id
 * @property string $spop_data_value
 */
class SPOPData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SPOP_Data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['spop_data_value'], 'required'],
            [['spop_data_value'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'spop_data_id' => Yii::t('app', 'Spop Data ID'),
            'spop_data_value' => Yii::t('app', 'Spop Data Value'),
        ];
    }
}
