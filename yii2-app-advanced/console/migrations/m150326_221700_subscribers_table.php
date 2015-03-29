<?php

use yii\db\Schema;
use yii\db\Migration;

class m150326_221700_subscribers_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('subscribers', [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

//        $this->addForeignKey("fk_subscriber_project", "subscriber", "id", "project_subscriber", "subscriber_id", "CASCADE", "RESTRICT");
    }

    public function down()
    {
        $this->dropTable('subscribers');
    }
}
