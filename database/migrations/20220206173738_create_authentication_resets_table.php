<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class CreateAuthenticationResetsTable extends AbstractMigration
{
    private $tableName = "authentication_resets";

    public function up()
    {
        if (Capsule::schema()->hasTable($this->tableName)) {
            return false;
        }

        Capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('user')->unsigned();
            $table->string('selector', 20)->unique();
            $table->string('token', 255);
            $table->integer('expires')->unsigned();

            $table->index(['user', 'expires']);
        });
    }

    public function down()
    {
        Capsule::schema()->drop($this->tableName);
    }
}
