<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_admins')->insert([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'nickname' => '超级管理员',
            'email' => 'admin@admin.com',
            'status' => 1
        ]);
    }
}
