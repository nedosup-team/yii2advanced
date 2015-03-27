<?php

use yii\db\Schema;
use yii\db\Migration;

class m150326_221600_project_subscriber_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('project_subscriber', [
            'id' => Schema::TYPE_PK,
            'project_id' => Schema::TYPE_INTEGER,
            'subscriber_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex('index_project_subscriber', 'project_subscriber', 'project_id', false);
        $this->createIndex('index_subscriber_project', 'project_subscriber', 'subscriber_id', false);
    }

    public function down()
    {
        $this->dropTable('project_subscriber');
    }
}
