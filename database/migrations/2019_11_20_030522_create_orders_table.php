<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->default(0);
            $table->integer('total')->comment('订单总金额')->default(0);
            $table->integer('actual')->comment('实际收到')->default(0);
            $table->integer('discount')->comment('优惠金额')->default(0);
            $table->integer('royalty')->comment('分成金额')->default(0);
            $table->integer('arrears')->comment('拖欠金额')->default(0);
            $table->integer('refund')->comment('退款金额')->default(0);
            $table->string('order_user')->comment('下单用户')->nullable();
            $table->string('order_linkman')->comment('联系人')->nullable();
            $table->string('order_contact')->comment('联系方式')->nullable();
            $table->string('order_address')->comment('联系地址')->nullable();
            $table->timestamp('execution_at')->nullable();
            $table->text('remark')->nullable();
            $table->text('detailed')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
