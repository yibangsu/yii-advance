<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "File_Base".
 *
 * @property int $rnl_id
 * @property string $rnl_tag
 * @property string $rnl_note
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
            [['rnl_tag', 'rnl_note'], 'required'],
            [['rnl_tag', 'rnl_note'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rnl_id' => Yii::t('app', 'ID'),
            'rnl_tag' => Yii::t('app', 'Tag'),
            'rnl_note' => Yii::t('app', 'Name'),
        ];
    }
}
