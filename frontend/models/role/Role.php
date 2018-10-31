<?php

namespace frontend\models\role;

use Yii;
use yii\base\Model;
use common\models\User;
/**
 *
 */
class Role extends Model
{
    /**
     *
     */
    public static function beAdmin()
    {
        $id = Yii::$app->user->id;
        $user = User::findOne($id);
        return ($user->username === "admin");
    }
}
