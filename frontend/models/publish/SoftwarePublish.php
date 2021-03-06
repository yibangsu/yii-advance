<?php

namespace frontend\models\publish;

use Yii;
use frontend\models\software\Software;
use frontend\models\role\Role;

/**
 * This is the model class for table "Software_Publish".
 *
 * @property int $sp_id
 * @property int $sp_sw_id
 * @property int $sp_file_count
 * @property string $sp_date
 * @property int $sp_puid
 * @property int $sp_publisher
 *
 * @property Software $spSw
 * @property ProductInfo $spPu 
 * @property User $spPublisher
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
            [['sp_sw_id', 'sp_file_count', 'sp_date', 'sp_puid', 'sp_publisher'], 'required'],
            [['sp_id', 'sp_sw_id', 'sp_file_count', 'sp_puid', 'sp_publisher'], 'integer'],
            [['sp_date'], 'safe'],
            [['sp_id'], 'unique'],
            [['sp_sw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['sp_sw_id' => 'sw_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->sp_file_count = 1;
        $this->sp_puid = Yii::$app->user->getUserCache('puidId');
        $this->sp_publisher = Yii::$app->user->id;
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        $this->sp_file_count = 1;
        $this->sp_puid = Yii::$app->user->getUserCache('puidId');
        $this->sp_publisher = Yii::$app->user->id;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
         if (strval($this->sp_publisher) === strval(Yii::$app->user->id) 
             && strval($this->sp_puid) === strval(Yii::$app->user->getUserCache('puidId'))
             || Role::beAdmin()) 
         {
             $this->sp_date = date("Y-m-d h:i:s",time());
             return parent::save($runValidation, $attributeNames);
         }
         return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update($runValidation = true, $attributeNames = null)
    {
         if (strval($this->sp_publisher) === strval(Yii::$app->user->id) 
             && strval($this->sp_puid) === strval(Yii::$app->user->getUserCache('puidId')) 
             || Role::beAdmin()) 
         {
             $this->sp_date = date("Y-m-d h:i:s",time());
             return parent::update($runValidation, $attributeNames);
         }
         return false;
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
            'sp_puid' => Yii::t('app', 'Sp Puid'), 
            'sp_publisher' => Yii::t('app', 'Sp Publisher'),
        ];
    }

}
