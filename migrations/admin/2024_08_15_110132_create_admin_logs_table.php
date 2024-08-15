<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index()->comment('用户ID');
            $table->string('url')->index()->comment('请求的接口');
            $table->text('data')->comment('请求数据');
            $table->string('ip', 30)->comment('ip地址');
            $table->integer('created_at')->index()->comment('添加时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
}
