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
                'user_id' => $this->user_id(),
                'first_name' => 'Azizbek',
                'last_name' => 'Karimov',
                'username' => 'azizbek_01',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => $this->user_id(),
                'first_name' => 'Dilnoza',
                'last_name' => 'Rahimova',
                'username' => 'dilnoza_psy',
                'mood_style' => 'emoji',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => $this->user_id(),
                'first_name' => 'Sardor',
                'last_name' => 'Yusupov',
                'username' => 'sardor_dev',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => $this->user_id(),
                'first_name' => 'Mohira',
                'last_name' => 'Tursunova',
                'username' => 'mohira_uz',
                'mood_style' => 'emoji',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => $this->user_id(),
                'first_name' => 'Jasur',
                'last_name' => 'Nazarov',
                'username' => 'jasur_n',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => $this->user_id(),
                'first_name' => 'Madina',
                'last_name' => 'Sodiqova',
                'username' => 'madina_live',
                'mood_style' => 'emoji',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => $this->user_id(),
                'first_name' => 'Otabek',
                'last_name' => 'Qodirov',
                'username' => 'otabek_q',
                'mood_style' => 'number',
                'is_active' => true,
                'is_admin' => false,
            ],
            [
                'user_id' => $this->user_id(),
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

    public function user_id()
    {
        return rand(100,999) . rand(100, 999) . rand(10, 99) . rand(10, 99);
    }
}
