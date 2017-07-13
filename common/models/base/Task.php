<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id_task
 * @property string $name
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deadline
 * @property integer $fk_status
 *
 * @property Status $fkStatus
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'created_at', 'updated_at', 'fk_status'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deadline', 'fk_status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['fk_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['fk_status' => 'id_status']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_task' => Yii::t('user', 'Идентификатор'),
            'name' => Yii::t('user', 'Название'),
            'description' => Yii::t('user', 'Описание'),
            'created_at' => Yii::t('user', 'Создана'),
            'updated_at' => Yii::t('user', 'Обновлена'),
            'deadline' => Yii::t('user', 'Срок выполнения'),
            'fk_status' => Yii::t('user', 'Статус'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStatus()
    {
        return $this->hasOne(Status::className(), ['id_status' => 'fk_status']);
    }

    /**
     * @inheritdoc
     * @return \common\queries\TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\queries\TaskQuery(get_called_class());
    }
}
