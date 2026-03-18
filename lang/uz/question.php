<?php

return [
    'testing_disorders'        => '<b>☑️ Ruhiy buzilishlarni testdan oʻtkazish

Testdan oʻtkazish — tashxis qoʻyish va psixopatologik holat dinamikasini kuzatishda yordamchi vositadir.

Test natijasi faqatgina buzilish mavjudligi yoki yoʻqligi ehtimolini koʻrsatadi va mutaxassisga murojaat qilish zarurligini baholashga yordam beradi. Klinik tashxis qoʻyish va ruhiy buzilishlarni davolash bilan shifokor-psixiatr shugʻullanadi. Testning manfiy natijasi kasallik yoʻqligini toʻliq kafolatlamaydi.</b>',

    /**
     * :name - test kategoriyasi nomi
     * :description - kategoriya tavsifi
     */
    'category'                 => '<b>:name

:description</b>',

    /**
     * :name - test nomi
     * :description - test haqida qisqacha ma'lumot
     * :sort - savolning tartib raqami
     * :count - savollarning umumiy soni
     * :question - joriy savol matni
     * :option_list - javob variantlari ro'yxati
     */
    'test_action_started'      => '<b>:name

:description

Savol №:sort / :count:

:question
:option_list</b>',

    /**
     * :name - test nomi
     * :sort - savolning tartib raqami
     * :count - savollarning umumiy soni
     * :question - joriy savol matni
     * :option_list - javob variantlari ro'yxati
     */
    'test_action'              => '<b>:name

Savol №:sort / :count:

:question
:option_list</b>',

    /**
     * :name - test nomi
     * :score - to'plangan ballar soni
     * :description - test natijasi talqini
     * :category - test tegishli bo'lgan kategoriya nomi
     */
    'finish_action'            => '<b>:name

Siz :score ball toʻpladingiz

:description

E’tibor bering, testdan oʻtish shifokor koʻrigi oʻrnini bosmaydi. Agar ruhiy salomatligingiz boʻyicha shikoyatlaringiz boʻlsa, faqat oʻz-oʻzingizga tashxis qoʻyish bilan cheklanmasdan, mutaxassisga murojaat qilganingiz ma’qul.

Joriy holatga aniqlik kiritish uchun «:category» boʻlimidagi boshqa testlardan ham oʻtishingiz mumkin.</b>',

    /**
     * :name - test nomi
     */
    'prev_results'             => '<b>:name

Avvalgi test natijalari:</b>',

    /**
     * :name - test nomi
     * :result_list - natijalar bilan avvalgi testlar ro'yxati
     */
    'result_list'              => '<b>:name

:result_list</b>',

    /**
     * :question - savol matni
     * :answer - tanlangan javob
     */
    'result_item'              => '<b>Savol: :question
Javob: :answer</b>',

    /**
     * :name - test nomi
     * :info - natija tavsifi va talqini
     */
    'interpretation_of_result' => '<b>:name

:info</b>',
];