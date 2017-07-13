<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m170713_151320_create_task_table extends Migration
{
    const TABLE_NAME = 'public.task';


    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id_task' => $this->primaryKey()->comment('Идентификатор'),
            'name' => $this->string(255)->notNull()->comment('Название'),
            'description' => $this->text()->notNull()->comment('Описание'),
            'created_at' => $this->integer()->notNull()->comment('Создана'),
            'updated_at' => $this->integer()->notNull()->comment('Обновлена'),
            'deadline' => $this->integer()->comment('Срок выполнения'),
            'fk_status' => $this->integer()->notNull()->comment('Статус'),
        ]);

        $this->addForeignKey('fk_task_status', self::TABLE_NAME, 'fk_status', 'public.status', 'id_status');
        $this->createIndex('ix_task_fk_status', self::TABLE_NAME, 'fk_status');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_task_status', self::TABLE_NAME);
        $this->dropIndex('ix_task_fk_status', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
