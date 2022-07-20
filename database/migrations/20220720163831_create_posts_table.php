<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class CreatePostsTable extends AbstractMigration
{
    private $tableName = "posts";

    public function up()
    {
        if (Capsule::schema()->hasTable($this->tableName)) {
            return false;
        }

        Capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->integer('id', true)->primary()->unique();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
            $table->string('title', 255);
            $table->longText('content');
            $table->text('imageUrl')->nullable();
            $table->boolean('published')->default(true);
            $table->integer('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Capsule::schema()->drop($this->tableName);
    }
}
