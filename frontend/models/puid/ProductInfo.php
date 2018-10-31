<?php

namespace frontend\models\puid;

use Yii;
use frontend\models\category\Category;
use frontend\models\fotaSrc\UpgradeConfiguration;
use frontend\models\role\Role;

/**
 * This is the model class for table "Product_Info".
 *
 * @property int $pi_id
 * @property string $PUID
 * @property int $pi_cp_id
 * @property int $cp_used
 * @property string $pi_date
 * @property int $pi_u_id
 *
 * @property Category $piCp
 * @property Software[] $softwares
 * @property UpgradeConfiguration[] $upgradeConfigurations
 */
class ProductInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Product_Info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PUID', 'pi_cp_id', 'pi_date', 'pi_u_id'], 'required'],
            [['pi_id', 'pi_cp_id', 'cp_used', 'pi_u_id'], 'integer'],
            [['pi_date'], 'safe'],
            [['PUID'], 'string', 'max' => 20],
            [['PUID'], 'unique'],
            [['pi_id'], 'unique'],
            [['pi_cp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['pi_cp_id' => 'cp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pi_id' => Yii::t('app', 'ID'),
            'PUID' => Yii::t('app', 'Puid'),
            'pi_cp_id' => Yii::t('app', 'Category ID'),
            'cp_used' => Yii::t('app', 'Used'),
            'pi_date' => Yii::t('app', 'Date'),
            'pi_u_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null, $activeRecord = true)
    {
        $id = $this->pi_id;
        $uid = $this->pi_u_id;

        $result = parent::load($data, $formName);

        $this->pi_cp_id = Yii::$app->user->getUserCache('categoryId');
        $this->cp_used = 1;

        if ($id) {
            $this->pi_id = $id;
        }

        if ($uid) {
            $this->pi_u_id = $uid;
        } else {
            $this->pi_u_id = Yii::$app->user->id;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        if (strval($this->pi_u_id) === strval(Yii::$app->user->id) || Role::beAdmin()) {
            $this->pi_date = date("Y-m-d h:i:s",time());
            return parent::update($runValidation, $attributeNames);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (strval($this->pi_u_id) === strval(Yii::$app->user->id) || Role::beAdmin()) {
            $this->pi_date = date("Y-m-d h:i:s",time());
            return parent::save($runValidation, $attributeNames);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        if (strval($this->pi_u_id) === strval(Yii::$app->user->id) || Role::beAdmin()) {
            $configs = UpgradeConfiguration::findAll(['uc_puid' => $this->pi_id]);
            foreach ($configs as $config) {
                $config->delete();
            }
            return parent::delete();
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
/*
    public function hasCategory()
    {
        return $this->hasOne(Category::className(), ['cp_id' => 'pi_cp_id']);
    }
*/

    /**
     * @return \yii\db\ActiveQuery
     */
/*
    public function hasSoftwares()
    {
        return $this->hasMany(Software::className(), ['sw_puid' => 'pi_id']);
    }
*/

    /**
     * @return \yii\db\ActiveQuery
     */
/*
    public function hasUpgradeConfigurations()
    {
        return $this->hasMany(UpgradeConfiguration::className(), ['uc_puid' => 'pi_id']);
    }
*/
}
