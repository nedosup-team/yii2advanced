<?php

use yii\db\Schema;
use yii\db\Migration;

class m150326_221604_projects_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('projects', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
            'description' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_SMALLINT,
            'author_id' => Schema::TYPE_INTEGER,
            'program_id' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('index_project_user', 'projects', 'author_id', false);
        $this->createIndex('index_project_program', 'projects', 'program_id', false);

        $this->addForeignKey("fk_news_project", "news", "project_id", "projects", "id", "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_user_project", "projects", "author_id", "user", "id", "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_project_subscriber", "project_subscriber", "project_id", "projects", "id", "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_type_project", "project_type", "project_id", "projects", "id", "CASCADE", "RESTRICT");
    }

    public function down()
    {
        $this->dropTable('projects');
    }
}
