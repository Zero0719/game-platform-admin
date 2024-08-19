<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePaymentProvidersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('支付商名称');
            $table->string('app_id')->default('')->comment('app_id');
            $table->text('app_secret')->comment('支付密钥');
            $table->boolean('status')->default(1)->comment('状态');
            $table->boolean('is_access')->default(0)->comment('是否完成接入');
            $table->string('notify_url')->default('')->comment('支付回调地址');
            $table->string('remark')->default('')->comment('备注');
            $table->integer('created_at')->default(0)->comment('添加时间');
            $table->integer('created_user')->default(0)->comment('添加人');
            $table->integer('updated_at')->default(0)->comment('更新时间');
            $table->integer('updated_user')->default(0)->comment('更新人');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_providers');
    }
}
