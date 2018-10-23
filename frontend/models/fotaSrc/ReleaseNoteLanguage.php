<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "File_Base".
 *
 * @property int $rnl_id
 * @property string $rnl_name
 *
 * @property FileExtend[] $fileExtends
 */
class ReleaseNoteLanguage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Release_Note_Language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rnl_name'], 'required'],
            [['rnl_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rnl_id' => Yii::t('app', 'ID'),
            'rnl_name' => Yii::t('app', 'Name'),
        ];
    }
}
