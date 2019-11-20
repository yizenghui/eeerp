<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->comment('生产者')->default(0);
            $table->integer('product_id')->comment('产品id')->default(0);
            $table->integer('total')->comment('总计生产数')->default(0);
            $table->integer('qualified')->comment('合格数')->default(0);
            $table->integer('unqualified')->comment('不合格数')->default(0);
            $table->string('batch')->comment('生产批次')->nullable();
            $table->timestamp('production_at')->comment('生产日期')->nullable();
            $table->text('remark')->nullable();
            $table->text('detailed')->comment('详细')->nullable();
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
        Schema::dropIfExists('productions');
    }
}
