<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    private $tableName = "users";

    public function up()
    {
        if (Capsule::schema()->hasTable($this->tableName)) {
            return false;
        }

        Capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->integer('id', true)->primary()->unique();
            $table->string('name', 255);
            $table->string('phone', 255)->nullable()->unique();
            $table->string('photoUrl', 255)->nullable();

            $table->foreign('id')->references('id')->on('authentication')->onDelete('cascade');
        });
    }

    public function down()
    {
        Capsule::schema()->drop($this->tableName);
    }
}
