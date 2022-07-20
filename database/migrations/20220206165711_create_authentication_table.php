<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class CreateAuthenticationTable extends AbstractMigration
{
    private $tableName = "authentication";

    public function up()
    {
        if (Capsule::schema()->hasTable($this->tableName)) {
            return false;
        }

        Capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->integer('id', true)->primary()->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('username', 100)->nullable();
            $table->boolean('verified')->default(false)->unsigned();
            $table->boolean('status')->default(false)->unsigned();
            $table->boolean('resettable')->default(true)->unsigned();
            $table->integer('roles_mask')->default(0)->unsigned();
            $table->integer('registered')->unsigned();
            $table->integer('last_login')->nullable()->unsigned();
            $table->mediumInteger('force_logout')->default(0)->unsigned();
        });
    }

    public function down()
    {
        Capsule::schema()->drop($this->tableName);
    }
}
