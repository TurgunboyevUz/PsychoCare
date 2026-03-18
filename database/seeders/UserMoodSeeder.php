<?php
namespace Database\Seeders;

use App\Models\TeleUser;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserMoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            1 => [
                "Juda yomon, tushkun holatdaman",
                "Hech narsa qilgim kelmayapti",
                "Atrofga nisbatan qiziqish so‘ngan",
                "Hamma narsa asabimga tegmoqda",
                "Kayfiyatim nolga teng",
            ],
            2 => [
                "Charchoq va loqaydlik bor",
                "O‘zimni biroz noqulay his qilyapman",
                "Hech qanday energiya qolmagan",
                "Biroq uyqum kelyapti",
                "Yolg‘iz qolishni xohlayman",
            ],
            3 => [
                "Kayfiyatim pastroq, lekin chidasa bo‘ladi",
                "Nimadir kamdek tuyulyapti",
                "Ishlarim unchalik yurishmayapti",
                "Biroz xafagarchilik bor",
                "Yaxshi yangilikka muhtojman",
            ],
            4 => [
                "O‘rtachadan pastroq kayfiyat",
                "Hech qanday emotsiya yo‘q",
                "Oddiy, biroz zerikarli kun",
                "Diqqatni jamlash qiyin bo‘lyapti",
                "Yaxshi tomonga o‘zgarish kutayapman",
            ],
            5 => [
                "O‘rtacha, hammasi joyida",
                "Neytral holatdaman",
                "Yaxshi ham emas, yomon ham emas",
                "Sokinlik va xotirjamlik",
                "Odatiy ish tartibidaman",
            ],
            6 => [
                "Yaxshi, yomon emas",
                "Biroz ko‘tarinkilik bor",
                "Kunning o‘tishi qoniqarli",
                "Yangi rejalarga kuch topiladi",
                "Tabassum qilishga sabab bor",
            ],
            7 => [
                "Kayfiyatim ancha yaxshi",
                "O‘zimni ancha tetik his qilyapman",
                "Bugungi kun samarali o‘tmoqda",
                "Atrofdagilarga ijobiy energiya beryapman",
                "Ishlarim o‘ngidan kelyapti",
            ],
            8 => [
                "Juda yaxshi, xursandman",
                "Energiya va motivatsiyaga to‘laman",
                "Hamma narsa a’lo darajada ketmoqda",
                "O‘zimga bo‘lgan ishonch yuqori",
                "Ajoyib kun bo‘lyapti",
            ],
            9 => [
                "Mukammal kayfiyat!",
                "O‘zimni dunyodagi eng baxtli insondek his qilyapman",
                "Hammasi kutilganidan ham yaxshiroq",
                "Zafarlar va g‘alabalarga to‘la holat",
                "Tog‘ni talqon qilishga tayyorman",
            ],
        ];

        $users = TeleUser::all();

        $baseTime = Carbon::parse('11-03-2026 01:07');

        foreach ($users as $user) {
            for ($i = 0; $i < rand(4, 8); $i++) {
                $created_at = $baseTime->clone()->addDays(rand(1, 5))->addHours(rand(1, 22));

                $mood    = rand(1, 9);
                $comment = $comments[$mood][rand(0, 4)];

                $user->moods()->create([
                    'mood_id'          => $mood,
                    'comment'          => $comment,
                    'via_notification' => rand(0, 1),
                    'updated_at'       => $created_at,
                    'created_at'       => $created_at,
                ]);
            }
        }
    }
}
