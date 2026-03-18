<?php

namespace Database\Seeders;

use App\Models\Mood;
use Illuminate\Database\Seeder;

class MoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Eyforiya. Go‘yo sarmastdekman. Hayot go‘zal, hech narsa kayfiyatimni buza olmaydi. Atrofdagi hamma narsadan xursandman, hayotdan zavqlanyapman. Kuch-g‘ayrat to‘lib-toshmoqda, hatto me’yoridan ortiq. O‘zimni to‘xtata olmayapman. Har qanday sarguzasht va o‘ylanmagan harakatlarga tayyorman.',
                'number_label' => '9️⃣',
                'emoji_label' => '🤣',
                'value' => 9,
            ],
            [
                'description' => 'Men o‘z formamdaman. Hazillashyapman, o‘tkir zehnlilik qilyapman, g‘oyalar bilan yonmoqdaman, sevimli mashg‘ulotlarimni eslayapman. Ijod va sport bilan bandman. Atrofdagilar bilan energiya ulashgim, ularni qo‘llab-quvvatlagim kelyapti. Hammasi juda ajoyib. Kayfiyat a’lo, energiya ko‘p. Empatiya (his qilish) eng yuqori darajada.',
                'number_label' => '8️⃣',
                'emoji_label' => '😂',
                'value' => 8,
            ],
            [
                'description' => 'Yaxshi, hayajonli holat. Ko‘chaga chiqish, muloqot qilish, mashq qilish va ishlash ishtiyoqi bor. Juda ham quvnoqman.',
                'number_label' => '7️⃣',
                'emoji_label' => '😆',
                'value' => 7,
            ],
            [
                'description' => 'Kayfiyat ko‘tarinki, lekin nazorat ostida. Ish qobiliyati yaxshi darajada.',
                'number_label' => '6️⃣',
                'emoji_label' => '😀',
                'value' => 6,
            ],
            [
                'description' => 'Barqaror. Keskin o‘zgarishlarsiz. Xotirjam. Komfort holatda.',
                'number_label' => '5️⃣',
                'emoji_label' => '😀',
                'value' => 5,
            ],
            [
                'description' => 'Yomon emas yoki shunchaki oddiy. Go‘yoki hammasi joyidagidek, lekin nimadir yetishmayotgandek. Kayfiyat biroz ma’yus (melanxolik).',
                'number_label' => '4️⃣',
                'emoji_label' => '😕',
                'value' => 4,
            ],
            [
                'description' => 'Bo‘shliq, g‘amginlik, zerikarli. Vakuum holati. Hammasiga befarqman.',
                'number_label' => '3️⃣',
                'emoji_label' => '😔',
                'value' => 3,
            ],
            [
                'description' => 'Apatiya (loqaydlik). Ishlashni ham, muloqot qilishni ham xohlamayman, bunga kuchim ham yo‘q. Hamma narsadan berkinish istagi bor. Noziklik, asabiylik, yig‘loqilik. Tez xafa bo‘laman. Hamma narsani negativ prizmasi orqali ko‘ryapman.',
                'number_label' => '2️⃣',
                'emoji_label' => '😩',
                'value' => 2,
            ],
            [
                'description' => 'Bularning barchasiga bardosh berish juda qiyin, nima qilishni bilmayman, to‘liq loqaydlik. Yashashga xohish ham, ma’no ham qolmagan. Vaziyatdan chiqish yo‘li borligiga va hayot yana quvonchli bo‘lishiga ishonmayman. Kun bo‘yi kuchsiz va hissiz yotibman.',
                'number_label' => '1️⃣',
                'emoji_label' => '😭',
                'value' => 1,
            ],
        ];

        Mood::insert($data);
    }
}