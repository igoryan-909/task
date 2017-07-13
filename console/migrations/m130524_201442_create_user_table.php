<?php

use yii\db\Migration;

class m130524_201442_create_user_table extends Migration
{
    const TABLE_NAME = 'public.user';
    const ADMIN_PASSWORD = '12345';


    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id_user' => $this->primaryKey()->comment('Идентификатор'),
            'username' => $this->string()->notNull()->unique()->comment('Имя пользователя'),
            'email' => $this->string()->notNull()->unique()->comment('E-mail'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('Статус'),
            'created_at' => $this->integer()->notNull()->comment('Создан'),
            'updated_at' => $this->integer()->notNull()->comment('Обновлен'),
        ]);

        $this->insert(self::TABLE_NAME, [
            'username' => 'admin',
            'email' => 'admin@task-admin.dev',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash(self::ADMIN_PASSWORD),
            'password_reset_token' => Yii::$app->security->generateRandomString() . '_' . time(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
