<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class CreateAuthenticationThrottlingTable extends AbstractMigration
{
    private $tableName = "authentication_throttling";

    public function up()
    {
        if (Capsule::schema()->hasTable($this->tableName)) {
            return false;
        }

        Capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->string('bucket', 44)->primary();
            $table->float('tokens')->unsigned();
            $table->integer('replenished_at')->unsigned();
            $table->integer('expires_at')->unsigned()->index();
        });
    }

    public function down()
    {
        Capsule::schema()->drop($this->tableName);
    }
}
