<?php

namespace common\models;

use common\models\base\Task as BaseTask;
use yii\behaviors\TimestampBehavior;


class Task extends BaseTask
{
    const SCENARIO_CHANGE_STATUS = 'changeStatus';


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'fk_status'], 'required'],
            [['description'], 'string', 'max' => 4000],
            [['created_at', 'updated_at', 'deadline', 'fk_status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['fk_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['fk_status' => 'id_status']],
        ];
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CHANGE_STATUS => ['fk_status'],
        ]);
    }
}
