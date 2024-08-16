<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('支付方式');
            $table->tinyInteger('type')->default(0)->comment('支付类型:1微信2支付宝3ios内购4银联5钱包');
            $table->string('pay_platform')->default('')->comment('支付平台');
            $table->string('app_id')->default('')->comment('app_id');
            $table->integer('created_at')->default(0)->comment('添加时间');
            $table->integer('created_user')->default('')->comment('添加人');
            $table->integer('updated_at')->default(0)->comment('修改人');
            $table->integer('updated_user')->default(0)->comment('修改时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}
