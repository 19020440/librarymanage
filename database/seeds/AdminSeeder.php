<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            'name' => 'Nhóm 5',
            'admin' => 'nhomso5',
            'password' => Hash::make('123456789')
        ]);
    }
}
