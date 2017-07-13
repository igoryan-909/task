<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id_status
 * @property string $name
 * @property integer $weight
 *
 * @property Task[] $tasks
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['weight'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_status' => Yii::t('user', 'Идентификатор'),
            'name' => Yii::t('user', 'Статус'),
            'weight' => Yii::t('user', 'Вес'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['fk_status' => 'id_status']);
    }

    /**
     * @inheritdoc
     * @return \common\queries\StatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\queries\StatusQuery(get_called_class());
    }
}
