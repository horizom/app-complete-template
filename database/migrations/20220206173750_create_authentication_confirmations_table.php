<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class CreateAuthenticationConfirmationsTable extends AbstractMigration
{
    private $tableName = "authentication_confirmations";

    public function up()
    {
        if (Capsule::schema()->hasTable($this->tableName)) {
            return false;
        }

        Capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->index()->unsigned();
            $table->string('email', 249);
            $table->string('selector', 16)->unique();
            $table->string('token', 255);
            $table->integer('expires')->unsigned();

            $table->index(['email', 'expires']);
        });
    }

    public function down()
    {
        Capsule::schema()->drop($this->tableName);
    }
}
