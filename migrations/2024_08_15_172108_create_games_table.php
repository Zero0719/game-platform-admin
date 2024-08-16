<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('游戏名称');
            $table->boolean('status')->default(1)->comment('游戏状态');
            $table->integer('created_at')->default(0)->comment('添加时间');
            $table->integer('created_user')->default(0)->comment('添加人');
            $table->integer('updated_at')->default(0)->comment('修改时间');
            $table->integer('updated_user')->default(0)->comment('修改人');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
