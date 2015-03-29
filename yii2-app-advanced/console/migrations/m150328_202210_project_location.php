<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_202210_project_location extends Migration {
	public function up()
	{
		$this->addColumn('projects', 'lat', Schema::TYPE_STRING);
		$this->addColumn('projects', 'lng', Schema::TYPE_STRING);
		$this->addColumn('projects', 'address', Schema::TYPE_STRING);
	}

	public function down()
	{
		$this->dropColumn('projects', 'lat');
		$this->dropColumn('projects', 'lng');
		$this->dropColumn('projects', 'address');
	}

}
