<?php

use yii\db\Migration;

/**
 * Class m180203_230216_create_table_user
 */
class m180203_230216_create_table_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(125)->notNull()->unique(),
            'auth_key' => $this->string(125)->notNull()->unique(),
            'password_hash' => $this->string(125)->notNull()->unique(),
            'email' => $this->string(125)->notNull()->unique(),
            'isAdmin' => $this->smallInteger(6)->notNull()->defaultValue(0),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(10),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->insert('user', [
            'username' => 'ferasdaeef',
            'auth_key' => 'iaraRFuk38mK540rcywZWMe_F8J0ke52',
            'password_hash' => '$2y$13$PphaENZtquUiJyymru04GuJ3O5gUY6V4QtgSB6WGfx1LneluSeteG',
            'email' => 'ferasit87@gmail.com',
            'isAdmin' => '1',
            'status' => '10',
            'created_at' => 'NOW()'

        ]);

        $this->insert('user', [
            'username' => 'feras.daeef',
            'auth_key' => 'Yd0R_AhmDSCXpmuMtAQhmXjmvwhVEnix',
            'password_hash' => '$2y$13$Tn/okjoyWMI2gAOXvTL.2.3xDZrd2esUzMLmq2/UImBFmxA3a1FsK',
            'email' => 'feras.daeef@gmail.com',
            'isAdmin' => '0',
            'status' => '10',
            'created_at' => 'NOW()'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'ferasdaeef']);
        $this->delete('user', ['username' => 'feras.daeef']);

        $this->dropTable('user');

    }
}
