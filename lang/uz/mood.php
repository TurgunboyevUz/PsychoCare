<?php

return [
    /**
     * :description_list - adminkadagi kayfiyatlar ro'yxatidan shakllangan ro'yxat (mood.daily_mood_item)
     */
    'daily_mood'               => '<b>📆 Kayfiyat kundaligi

Iltimos, hozirgi holatingizni baholang.

Baho tavsifga to‘liq mos kelishi shart emas. Shunchaki boshqalariga qaraganda sizga mosrog‘ini tanlang, holatingizning o‘ziga xos xususiyatlarini esa izohda ko‘rsatishingiz mumkin.

  :description_list

Agar kuningiz davomida holatingiz keskin o‘zgarsa, kundalikni tez-tez to‘ldirib turing.</b>',

    /**
     * :value - ball
     * :description - ballga mos keladigan kayfiyat tavsifi
     */
    'current_mood'             => '<b>📆 Kayfiyat kundaligi

Hozirgi vaqt uchun holatingiz bo‘yicha bahongiz: :value ball
:description

Ushbu bahoga javob xabari sifatida izoh yozishingiz mumkin. Masalan, holatingiz qanday o‘zgargani yoki bunga obyektiv sabablar bo‘lgan-bo‘lmagani haqida.

Iltimos, juda uzun matn yozmang. Buning hojati yo‘q</b>',

    /**
     * :value - ball
     * :description - ballga mos keladigan kayfiyat tavsifi
     * :comment - izoh
     */
    'current_mood_comment'     => '<b>📆 Kayfiyat kundaligi

Hozirgi vaqt uchun holatingiz bo‘yicha bahongiz: :value ball

:description

Izoh:
  :comment</b>',

    /**
     * :current_value - ball
     * :comment - izoh
     */
    'change_one_hour'          => '<b>📆 Kayfiyat kundaligi

Odatda, hissiy holatni har soatdan ko‘proq baholashning ma’nosi yo‘q.

Hozgi baho: :current_value ball</b>',

    /**
     * :current_value - ball
     * :comment - izoh
     */
    'change_one_hour_comment'  => '<b>📆 Kayfiyat kundaligi

Odatda, hissiy holatni har soatdan ko‘proq baholashning ma’nosi yo‘q.

Hozirgi baho: :current_value ball

Izoh:
  :comment</b>',

    /**
     * :label - emoji
     * :description - kayfiyat haqida
     */
    'daily_mood_item'          => '<b>:label :description</b>',

    /**
     * :link - grafik havolasi
     */
    'daily_mood_graph'         => '<b>📆 Kayfiyat kundaligi

<a href=":link">Bir martalik havola</a> yaratildi.

Agar grafikni masalan, baholash uchun shifokoringiz bilan baham ko‘rmoqchi bo‘lsangiz, havolaga o‘zingiz kirmasligingiz tavsiya etiladi.</b>',

    'mood_chosen'              => '<b>📆 Kayfiyat kundaligi

Sizning bahongiz qabul qilindi ✅

Ushbu bahoga javob xabari sifatida izoh yozishingiz mumkin.</b>',

    /**
     * :comment - izoh
     */
    'mood_chosen_with_comment' => '<b>📆 Kayfiyat kundaligi

Sizning bahongiz qabul qilindi ✅

Izoh:
  :comment</b>',

    'rewrite_comment'          => '<b>📆 Kayfiyat kundaligi

Yangi izohni javob xabari sifatida yozishingiz mumkin.

Iltimos, juda uzun matn yozmang. Buning hojati yo‘q</b>',

    'comment_input'            => '<b>Izohingiz inobatga olindi ✅</b>',

    'mood_settings'            => '<b>📆 Kayfiyat kundaligi

Sizning shaxsiy sozlamalaringiz</b>',

    /**
     * :zone - vaqt mintaqasi nomi (Europe/Moscow kabi)
     * :timezone - timezone (UTC+5 kabi)
     * :time - vaqt
     */
    'notification_settings'    => '<b>📆 Kayfiyat kundaligi

Iltimos, eslatma olishni xohlagan vaqtingizni* tanlang.

Kuniga bir necha marta bildirishnoma olish uchun bir nechta vaqtni tanlashingiz mumkin.


* - vaqt: :zone (:timezone) :time

⚠️ Diqqat! Eslatmalarni olishingiz uchun Telegram sozlamalarida istisnolarni sozlashingiz kerak bo‘lishi mumkin:

Sozlamalar -> Bildirishnomalar va ovozlar -> Shaxsiy chatlar

Agar bildirishnomalar o‘chirilgan bo‘lsa, @psy03bot chatini istisnolarga qo‘shing</b>',

    'notification_message'     => '<b>⏰ Kayfiyatni baholash vaqti keldi

Iltimos, kayfiyat kundaligida hozirgi holatingizni belgilang.

Kundalikni muntazam yuritish ruhiy holat o‘zgarishi dinamikasini aniqroq kuzatish imkonini beradi.

Siz ushbu xabarni joriy eslatma sozlamalaringizga muvofiq oldingiz</b>',

    /**
     * :zone - vaqt mintaqasi nomi
     * :datetime - vaqt va sana
     */
    'timezone_settings'        => '<b>📆 Kayfiyat kundaligi

Vaqt mintaqasini o‘zgartirish

Joriy vaqt mintaqasi: :zone

Hozirgi vaqt: :datetime
Sizda hozir soat necha bo‘lganini tanlang. Bu kayfiyat kundaligida vaqt to‘g‘ri ko‘rinishi va eslatmalar o‘z vaqtida kelishi uchun zarur</b>',

    /**
     * :zone - muvaffaqiyatli o'zgartirildi
     */
    'timezone_changed'         => '<b>📆 Kayfiyat kundaligi

Vaqt mintaqasini o‘zgartirish

✅ Siz vaqt mintaqasini muvaffaqiyatli :zone ga o‘zgartirdingiz.</b>',

    /**
     * :description_list - kayfiyatlar ro'yxati
     */
    'template_settings'        => '<b>📆 Kayfiyat kundaligi

Shablonni tahrirlash
Kerakli tugmani bosing va javob xabarida bahoning yangi tavsifini yuboring.

Sizning joriy shabloningiz:

  :description_list</b>',

    /**
     * :label - emoji
     * :description - kayfiyat haqida
     */
    'change_mood_item'         => '<b>📆 Kayfiyat kundaligi

Tahrirlanayotgan shablon:
:label - :description

Javob xabarida yangi tavsifni yuboring</b>',

    'mood_item_changed'        => '<b>Shabloningiz muvaffaqiyatli yangilandi ✅</b>',

    'default_template_changed' => '<b>📆 Kayfiyat kundaligi

✅ Standart shablon o‘rnatildi</b>',
];