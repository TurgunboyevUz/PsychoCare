<?php

namespace Database\Seeders;

use App\Models\TeleUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'user_id' => '100000001',
                'first_name' => 'Azizbek',
                'last_name' => 'Karimov',
                'username' => 'azizbek_01',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => '100000002',
                'first_name' => 'Dilnoza',
                'last_name' => 'Rahimova',
                'username' => 'dilnoza_psy',
                'mood_style' => 'emoji',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => '100000003',
                'first_name' => 'Sardor',
                'last_name' => 'Yusupov',
                'username' => 'sardor_dev',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => '100000004',
                'first_name' => 'Mohira',
                'last_name' => 'Tursunova',
                'username' => 'mohira_uz',
                'mood_style' => 'emoji',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => '100000005',
                'first_name' => 'Jasur',
                'last_name' => 'Nazarov',
                'username' => 'jasur_n',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => '100000006',
                'first_name' => 'Madina',
                'last_name' => 'Sodiqova',
                'username' => 'madina_live',
                'mood_style' => 'emoji',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => '100000007',
                'first_name' => 'Otabek',
                'last_name' => 'Qodirov',
                'username' => 'otabek_q',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => '100000008',
                'first_name' => 'Shahnoza',
                'last_name' => 'Rustamova',
                'username' => 'shahnoza_r',
                'mood_style' => 'emoji',
                'is_active' => true,
                'is_admin' => false,
            ],
        ];

        TeleUser::insert($users);
    }
}
