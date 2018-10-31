<?php

namespace frontend\models\fotaSrc;

use Yii;
use common\models\User;
use frontend\models\puid\ProductInfo;
use frontend\models\role\Role;

/**
 * This is the model class for table "Device".
 *
 * @property int $d_id
 * @property string $d_code
 * @property int $d_dg_id
 * @property string $d_bind_ver
 * @property string $d_date
 * @property int $d_u_id
 *
 * @property User $dU
 * @property ProductInfo $dPu 
 */
class Device extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Device';
    }

    /**
     * {@inheritdoc}
     */
    public function attributes ()
    {
        $attributes = parent::attributes();
        $attributes[] = 'creator';
        $attributes[] = 'deviceGroupName';
        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_puid', 'd_code', 'd_dg_id', 'd_date', 'd_u_id'], 'required'],
            [['d_puid', 'd_dg_id', 'd_u_id'], 'integer'],
            [['d_date'], 'safe'],
            [['d_code'], 'string', 'max' => 64],
            [['d_bind_ver'], 'string', 'max' => 20],
            [['d_u_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['d_u_id' => 'id']],
            [['d_puid'], 'exist', 'skipOnError' => true, 'targetClass' => ProductInfo::className(), 'targetAttribute' => ['d_puid' => 'pi_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'd_id' => Yii::t('app', 'ID'),
            'd_puid' => Yii::t('app', 'Puid'),
            'd_code' => Yii::t('app', 'Code'),
            'd_dg_id' => Yii::t('app', 'Device Group ID'),
            'd_bind_ver' => Yii::t('app', 'Bind Version'),
            'd_date' => Yii::t('app', 'Date'),
            'd_u_id' => Yii::t('app', 'Creator'),
            'deviceGroupName' => Yii::t('app', 'Device Group'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $creatorId = $this->d_u_id;
        $result = parent::load($data, $formName);
        $this->d_puid = Yii::$app->user->getUserCache('puidId');
        $this->d_u_id = $creatorId === null? Yii::$app->user->id: $creatorId;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->d_u_id === Yii::$app->user->id || Role::beAdmin()) {
            $this->d_date = date("Y-m-d h:i:s",time());
            if ('No Choose' === $this->d_bind_ver) {
                $this->d_bind_ver = null;
            }
            return parent::save($runValidation, $attributeNames);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        if ($this->d_u_id === Yii::$app->user->id || Role::beAdmin()) {
            $this->d_date = date("Y-m-d h:i:s",time());
            if ('No Choose' === $this->d_bind_ver) {
                $this->d_bind_ver = null;
            }
            return parent::update($runValidation, $attributeNames);
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDU()
    {
        return $this->hasOne(User::className(), ['id' => 'd_u_id']);
    }
}
