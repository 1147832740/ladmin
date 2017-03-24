<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',20)->notnull()->unique()->comment('用户名');
            $table->string('password',20)->notnull()->comment('密码');
            $table->string('nickname',20)->nullable()->default('')->comment('昵称');
            $table->string('email',60)->notnull()->unique()->comment('邮箱');
            $table->rememberToken();
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
        Schema::dropIfExists('adm_admins');
    }
}
