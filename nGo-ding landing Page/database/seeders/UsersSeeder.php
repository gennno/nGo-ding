<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'no_anggota' => 'ANG001',
                'name' => 'John',
                'role' => 'ketua',
                'password' => bcrypt('123')

            ],
            [
                'no_anggota' => 'ANG002',
                'name' => 'Toni',
                'role' => 'pengawas',
                'password' => bcrypt('123')

            ],
            [
                'no_anggota' => 'ANG003',
                'name' => 'Roni',
                'role' => 'Bendahara',
                'password' => bcrypt('123')
            ]

        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
