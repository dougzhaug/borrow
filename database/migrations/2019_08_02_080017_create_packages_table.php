<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('website_id')->comment('所属站点');
            $table->string('title')->comment('标题');
            $table->string('author')->comment('作者');
            $table->string('issuer_id')->comment('所属发行机构');
            $table->string('periodical_no')->comment('期刊编码');
            $table->timestamp('issue_at')->comment('发行时间');
            $table->integer('total')->comment('总发行量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
