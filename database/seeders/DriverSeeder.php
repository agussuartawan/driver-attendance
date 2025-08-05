<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create driver role if it doesn't exist
        $driverRole = Role::firstOrCreate(['name' => 'driver']);

        $drivers = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'vehicle' => 'Honda PCX 160',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567891',
                'vehicle' => 'Yamaha NMAX 155',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra.dewi@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567892',
                'vehicle' => 'Honda Vario 160',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567893',
                'vehicle' => 'Suzuki GSX-R150',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Eka Putri',
                'email' => 'eka.putri@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567894',
                'vehicle' => 'Kawasaki Ninja 250',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar.ramadhan@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567895',
                'vehicle' => 'Honda CB150R',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Gita Sari',
                'email' => 'gita.sari@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567896',
                'vehicle' => 'Yamaha XSR 155',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra.wijaya@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567897',
                'vehicle' => 'Honda ADV 150',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Indah Permata',
                'email' => 'indah.permata@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567898',
                'vehicle' => 'Yamaha Aerox 155',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567899',
                'vehicle' => 'Honda CRF150L',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Kartika Sari',
                'email' => 'kartika.sari@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567800',
                'vehicle' => 'Suzuki Address 110',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Lukman Hakim',
                'email' => 'lukman.hakim@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567801',
                'vehicle' => 'Kawasaki W175',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Maya Indah',
                'email' => 'maya.indah@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567802',
                'vehicle' => 'Honda Scoopy',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Nugraha Pratama',
                'email' => 'nugraha.pratama@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567803',
                'vehicle' => 'Yamaha R15 V4',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Oscar Pratama',
                'email' => 'oscar.pratama@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567804',
                'vehicle' => 'Honda CBR150R',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Putri Anggraini',
                'email' => 'putri.anggraini@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567805',
                'vehicle' => 'Yamaha XSR 155',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Rizki Maulana',
                'email' => 'rizki.maulana@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567806',
                'vehicle' => 'Suzuki GSX-S150',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567807',
                'vehicle' => 'Honda PCX 160',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Taufik Hidayat',
                'email' => 'taufik.hidayat@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567808',
                'vehicle' => 'Kawasaki D-Tracker 150',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Udin Santoso',
                'email' => 'udin.santoso@erni.com',
                'password' => Hash::make('password'),
                'phone' => '081234567809',
                'vehicle' => 'Yamaha NMAX 155',
                'image' => 'default-avatar.jpg',
                'status' => 'active',
            ],
        ];

        foreach ($drivers as $driver) {
            $user = User::create($driver);
            $user->assignRole($driverRole);
        }
    }
}
