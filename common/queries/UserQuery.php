<?php

namespace common\queries;

/**
 * This is the ActiveQuery class for [[\common\models\base\User]].
 *
 * @see \common\models\base\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\base\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\base\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
