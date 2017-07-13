<?php

use yii\db\Migration;

/**
 * Handles the creation of table `status`.
 */
class m170713_151316_create_status_table extends Migration
{
    const TABLE_NAME = 'public.status';


    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id_status' => $this->primaryKey()->comment('Идентификатор'),
            'name' => $this->string()->notNull()->unique()->comment('Статус'),
            'weight' => $this->integer()->notNull()->defaultValue(0)->comment('Вес'),
        ]);
        $this->batchInsert(self::TABLE_NAME, ['name', 'weight'], [
            ['Новая', 0],
            ['В работе', 1],
            ['Завершена', 2],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
