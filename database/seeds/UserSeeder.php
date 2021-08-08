<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Nhóm 5',
            'username' => 'nhomso5',
            'password' => Hash::make('123456789'),
            'birth' => '2021-07-05',
            'phone' => '0123456789',
            'email' => 'nhom5@gmail.com',
            'images' => 'images/avatar-default.png',
            'address' => 'Đại Học Công Nghệ'
        ]);
    }
}
