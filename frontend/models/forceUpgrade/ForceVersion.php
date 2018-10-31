<?php

namespace frontend\models\forceUpgrade;

use Yii;
use frontend\models\software\Software;
use common\models\User;
use frontend\models\puid\ProductInfo;

/**
 * This is the model class for table "Force_Version".
 *
 * @property int $fv_id
 * @property int $fv_sw_id
 * @property string $fv_date
 * @property int $fv_u_id
 * @property int $fv_puid
 *
 * @property Software $fvSw
 * @property User $fvU
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
            [['fv_sw_id', 'fv_date', 'fv_u_id', 'fv_puid'], 'required'],
            [['fv_sw_id', 'fv_u_id', 'fv_puid'], 'integer'],
            [['fv_date'], 'safe'],
            [['fv_sw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Software::className(), 'targetAttribute' => ['fv_sw_id' => 'sw_id']],
            [['fv_u_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fv_u_id' => 'id']],
            [['fv_puid'], 'exist', 'skipOnError' => true, 'targetClass' => ProductInfo::className(), 'targetAttribute' => ['fv_puid' => 'pi_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fv_id' => Yii::t('app', 'ID'),
            'fv_sw_id' => Yii::t('app', 'Software ID'),
            'fv_date' => Yii::t('app', 'Date'),
            'fv_u_id' => Yii::t('app', 'User ID'),
            'fv_puid' => Yii::t('app', 'PUID'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->fv_puid = Yii::$app->user->getUserCache('puidId');
        $this->fv_u_id = Yii::$app->user->id;
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $owner = $this->fv_u_id;
        $result = parent::load($data, $formName);
        $this->fv_puid = Yii::$app->user->getUserCache('puidId');
        if (!empty($owner)) {
            $this->fv_u_id = $owner;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
         if (strval($this->fv_u_id) === strval(Yii::$app->user->id) 
             && strval($this->fv_puid) === strval(Yii::$app->user->getUserCache('puidId'))
             || Role::beAdmin()) 
         {
             $this->fv_date = date("Y-m-d h:i:s",time());
             return parent::save($runValidation, $attributeNames);
         }
         return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update($runValidation = true, $attributeNames = null)
    {
         if (strval($this->fv_u_id) === strval(Yii::$app->user->id) 
             && strval($this->fv_puid) === strval(Yii::$app->user->getUserCache('puidId')) 
             || Role::beAdmin()) 
         {
             $this->fv_date = date("Y-m-d h:i:s",time());
             return parent::update($runValidation, $attributeNames);
         }
         return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasSoftware()
    {
        return $this->hasOne(Software::className(), ['sw_id' => 'fv_sw_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasUser()
    {
        return $this->hasOne(User::className(), ['pi_id' => 'fv_puid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasPuid()
    {
        return $this->hasOne(ProductInfo::className(), ['id' => 'fv_u_id']);
    }
}
