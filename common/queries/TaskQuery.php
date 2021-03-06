<?php

namespace common\queries;

/**
 * This is the ActiveQuery class for [[\common\models\base\Task]].
 *
 * @see \common\models\base\Task
 */
class TaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\base\Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\base\Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
