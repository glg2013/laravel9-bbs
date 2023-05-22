<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成数据集合
        User::factory()->count(10)->create();

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name     =   'fengniancong';
        $user->email    =   'fengniancong@163.com';
        $user->password =   bcrypt('glg7850782');
        $user->avatar   =   'http://larabbs.test/uploads/images/avatars/202305/18/1_1684394950_7hO90VcJ2x.jpg';
        $user->introduction =   'Stay hungry, stay foolish.';
        $user->save();
    }
}
