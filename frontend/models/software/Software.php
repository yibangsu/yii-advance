<?php

namespace frontend\models\software;

use Yii;
use frontend\models\puid\ProductInfo;

/**
 * This is the model class for table "Software".
 *
 * @property int $sw_id
 * @property string $sw_ver
 * @property int $sw_creator
 * @property string $sw_expiration_date
 * @property string $sw_release_note
 * @property string $sw_date
 * @property int $sw_puid
 *
 * @property FileExtend[] $fileExtends
 * @property FileExtend[] $fileExtends0
 * @property ForceVersion[] $forceVersions
 * @property ProductInfo $swPu
 * @property SoftwarePublish[] $softwarePublishes
 */
class Software extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Software';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sw_ver', 'sw_creator', 'sw_expiration_date', 'sw_release_note', 'sw_date', 'sw_puid'], 'required'],
            [['sw_creator', 'sw_puid'], 'integer'],
            [['sw_expiration_date', 'sw_date'], 'safe'],
            [['sw_release_note'], 'string'],
            [['sw_ver'], 'string', 'max' => 10],
            [['sw_ver'], 'unique'],
            [['sw_puid'], 'exist', 'skipOnError' => true, 'targetClass' => ProductInfo::className(), 'targetAttribute' => ['sw_puid' => 'pi_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sw_id' => Yii::t('app', 'ID'),
            'sw_ver' => Yii::t('app', 'Version'),
            'sw_creator' => Yii::t('app', 'Creator'),
            'sw_expiration_date' => Yii::t('app', 'Expiration Date'),
            'sw_release_note' => Yii::t('app', 'Release Note'),
            'sw_date' => Yii::t('app', 'Date'),
            'sw_puid' => Yii::t('app', 'Puid'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $id = $this->sw_id;
        $puid = $this->sw_puid;
        $creator = $this->sw_creator;
        $result = parent::load($data, $formName);
        // without sw_id, means this is a new list
        if (!$id) {
            $this->sw_creator = Yii::$app->user->id;
            $this->sw_puid = Yii::$app->user->getUserCache('puidId');
        } else {
            $this->sw_creator = $creator;
            $this->sw_puid = $puid;
            $this->sw_id = $id;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        if ($this->sw_creator === Yii::$app->user->id) {
            $this->sw_date = date("Y-m-d h:i:s",time());
            return parent::update($runValidation, $attributeNames);
        }

        return false;
    }

   /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->sw_creator === Yii::$app->user->id) {
            $this->sw_date = date("Y-m-d h:i:s",time());
            return parent::save($runValidation, $attributeNames);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        if ($this->sw_creator === Yii::$app->user->id) {
            return parent::delete();
        }

        return false;
    }
}
