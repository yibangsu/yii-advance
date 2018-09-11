<?php

namespace mdm\admin\models\rules;

use yii\rbac\Rule;
use app\models\Post;
use app\models\Get;

/**
 * 检查 authorID 是否和通过参数传进来的 user 参数相符
 */
class AdminRule extends Rule
{
    public $name = 'isAdmin';

    /**
     * @param string|integer $user 用户 ID.
     * @param Item $item 该规则相关的角色或者权限
     * @param array $params 传给 ManagerInterface::checkAccess() 的参数
     * @return boolean 代表该规则相关的角色或者权限是否被允许
     */
    public function execute($user, $item, $params)
    {
        \Yii::warning("user='$user'");
        //return isset($params['get']) ? $params['get']->createdBy == $user : false;
        return (2 == $user);
    }
}
