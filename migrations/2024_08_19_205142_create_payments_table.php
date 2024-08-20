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
            $table->string('name')->default('')->comment('支付方式名称');
            $table->integer('provider_id')->default(0)->comment('支付商');
            $table->integer('type')->default(0)->comment('支付类型');
            $table->string('remark')->default('')->comment('备注');
            $table->boolean('status')->default(1)->comment('状态');
            $table->integer('created_at')->default(0);
            $table->integer('created_user')->default(0);
            $table->integer('updated_at')->default(0);
            $table->integer('updated_user')->default(0);
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
