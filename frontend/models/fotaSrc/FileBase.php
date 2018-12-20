<?php

namespace frontend\models\fotaSrc;

use Yii;

/**
 * This is the model class for table "File_Base".
 *
 * @property int $fb_id
 * @property string $fb_name
 * @property string $fb_path
 * @property int $fb_status
 * @property string $fb_date
 * @property int $fb_size
 *
 * @property FileExtend[] $fileExtends
 */
class FileBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'File_Base';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fb_name', 'fb_path', 'fb_status', 'fb_date', 'fb_size'], 'required'],
            [['fb_status', 'fb_size'], 'integer'],
            [['fb_date'], 'safe'],
            [['fb_name'], 'string', 'max' => 64],
            [['fb_path'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fb_id' => Yii::t('app', 'ID'),
            'fb_name' => Yii::t('app', 'Name'),
            'fb_path' => Yii::t('app', 'Path'),
            'fb_status' => Yii::t('app', 'Status'),
            'fb_date' => Yii::t('app', 'Date'),
            'fb_size' => Yii::t('app', 'Size'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);

        $companyName = Yii::$app->user->getUserCompanyName();
        $projectName = Yii::$app->user->getUserCache('projectName');
        $categoryName = Yii::$app->user->getUserCache('categoryName');
        $puidName = Yii::$app->user->getUserCache('puidName');
        if (!$projectName || !$categoryName || !$puidName) {
            return false;
        }
        $this->fb_path = Yii::$app->params['s3BucketRoot'] 
                         . $companyName . '/'
                         . $projectName . '/'
                         . $categoryName . '/'
                         . $puidName . '/';

        $this->fb_status = 1;

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $result = false;

        try {
            $path = $this->getEc2Path();
            if (is_dir($path)) {
                unlink($path . $this->fb_name);
            }
            $result = parent::delete();
        } catch (Exception $e) {
            // do nothing
        } catch (yii\base\ErrorException $e) {
            // do nothing
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */


    /**
     * @return \yii\db\ActiveQuery
     */
    public function hasFileExtends()
    {
        return $this->hasMany(FileExtend::className(), ['fe_fb_id' => 'fb_id']);
    }

    /**
     * @return String - EC2 mouned path
     */
    public function getEc2Path()
    {
        if ($this->fb_path) {
            $ec2Root = Yii::$app->params['s2MountRoot'];
            $s3Root = Yii::$app->params['s3BucketRoot'];
            return strtr($this->fb_path, [$s3Root => $ec2Root]);
        }

        return null;
    }
}
