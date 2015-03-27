<?php

use yii\db\Schema;
use yii\db\Migration;

class m150326_221558_project_type_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('project_type', [
            'id' => Schema::TYPE_PK,
            'project_id' => Schema::TYPE_INTEGER,
            'type_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->createIndex('index_project_type', 'project_type', 'project_id', false);
        $this->createIndex('index_type_project', 'project_type', 'type_id', false);
    }

    public function down()
    {
        $this->dropTable('project_type');
    }
}
