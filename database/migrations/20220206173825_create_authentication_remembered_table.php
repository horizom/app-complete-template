<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class CreateAuthenticationRememberedTable extends AbstractMigration
{
    private $tableName = "authentication_remembered";

    public function up()
    {
        if (Capsule::schema()->hasTable($this->tableName)) {
            return false;
        }

        Capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('user')->index()->unsigned();
            $table->string('selector', 24)->unique();
            $table->string('token', 255);
            $table->integer('expires')->unsigned();
        });
    }

    public function down()
    {
        Capsule::schema()->drop($this->tableName);
    }
}
