<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_221700_user_role_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'role', Schema::TYPE_SMALLINT);
        $this->update('{{%user}}', ['role' => \common\models\User::ROLE_ADMIN], ['id' => 1]);
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'role');
    }
}
