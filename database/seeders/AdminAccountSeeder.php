<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->insert([
            'first_name_en' => 'admin',
            'last_name_en' => 'admin',
            'first_name_ar' => 'المسؤول',
            'last_name_ar' => 'المسؤول',
//            'encoded_image' => ,
            'phone_number' => '0999999999',
            'gender' => 'male',
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123!'),
        ]);
    }
}
