<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('user')->insert([
            'email' => 'geo@gmail.com',
            'password' => Hash::make('123'), // It's important to hash passwords
            'name' => 'Sample Name',
            'no_hp' => '1234567890', // Replace this with the actual phone number
            'avatar' => 'default_avatar.jpg', // Replace with the actual avatar filename
            'tanggal_lahir' => '1990-01-01', // Replace with the birth date
            'jk' => 'Laki-Laki', // Or 'Perempuan' based on the gender
            'roles' => 'student',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

