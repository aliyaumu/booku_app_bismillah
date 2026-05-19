<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Booku',
            'email' => 'admin@booku.com',
            'phone' => '081234567890',
            'student_id' => '10001',
            'address' => 'Perpustakaan Utama Booku, Gd. A Lantai 1',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // Members
        $members = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@booku.com',
                'phone' => '082111222333',
                'student_id' => '20210001',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@booku.com',
                'phone' => '082111222444',
                'student_id' => '20210002',
                'address' => 'Jl. Mawar No. 15, Bandung',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@booku.com',
                'phone' => '082111222555',
                'student_id' => '20210003',
                'address' => 'Jl. Melati No. 5, Surabaya',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@booku.com',
                'phone' => '082111222666',
                'student_id' => '20210004',
                'address' => 'Jl. Anggrek No. 22, Yogyakarta',
            ],
            [
                'name' => 'Rian Hidayat',
                'email' => 'rian@booku.com',
                'phone' => '082111222777',
                'student_id' => '20210005',
                'address' => 'Jl. Kenanga No. 8, Semarang',
            ],
        ];

        foreach ($members as $member) {
            User::create([
                'name' => $member['name'],
                'email' => $member['email'],
                'phone' => $member['phone'],
                'student_id' => $member['student_id'],
                'address' => $member['address'],
                'role' => 'member',
                'status' => 'active',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
