<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PsychoCare — Aqlli psixolog va psixiatr yordamchisi</title>
    <meta name="description"
        content="PsychoCare — kayfiyat monitoringi, testlar, shifokor bilan chat, dori xavfsizligi va Telegram eslatmalari bilan aqlli ruhiy salomatlik platformasi." />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef8ff',
                            100: '#d9f0ff',
                            200: '#bce5ff',
                            300: '#8bd5ff',
                            400: '#52bcff',
                            500: '#1d9cf5',
                            600: '#0a7fd6',
                            700: '#0865ad',
                            800: '#0c568f',
                            900: '#114a77'
                        },
                        accent: {
                            50: '#f3f1ff',
                            100: '#e8e3ff',
                            200: '#d6ccff',
                            300: '#b9a6ff',
                            400: '#9a77ff',
                            500: '#7f4bff',
                            600: '#6a2fe8',
                            700: '#5920c2',
                            800: '#4a1ca0',
                            900: '#3f1b82'
                        }
                    },
                    boxShadow: {
                        glow: '0 20px 70px rgba(29, 156, 245, 0.25)',
                        soft: '0 12px 35px rgba(15, 23, 42, 0.08)'
                    },
                    backgroundImage: {
                        mesh: 'radial-gradient(circle at 20% 20%, rgba(29,156,245,.22), transparent 28%), radial-gradient(circle at 80% 0%, rgba(127,75,255,.18), transparent 30%), radial-gradient(circle at 80% 70%, rgba(56,189,248,.16), transparent 28%), linear-gradient(180deg, #f8fbff 0%, #ffffff 100%)'
                    },
                    animation: {
                        floaty: 'floaty 6s ease-in-out infinite',
                        pulseSoft: 'pulseSoft 3s ease-in-out infinite'
                    },
                    keyframes: {
                        floaty: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            }
                        },
                        pulseSoft: {
                            '0%, 100%': {
                                transform: 'scale(1)',
                                opacity: '1'
                            },
                            '50%': {
                                transform: 'scale(1.04)',
                                opacity: '.92'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #ffffff;
            color: #0f172a;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.75);
        }

        .noise::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .06;
            background-image:
                radial-gradient(#0f172a 0.7px, transparent 0.7px),
                radial-gradient(#0f172a 0.7px, transparent 0.7px);
            background-position: 0 0, 12px 12px;
            background-size: 24px 24px;
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-card:hover .feature-icon {
            transform: translateY(-4px) scale(1.04);
        }

        .feature-icon {
            transition: transform .25s ease;
        }
    </style>
</head>

<body class="bg-white text-slate-900 antialiased">
    <div class="relative overflow-hidden bg-mesh noise">
        <div class="absolute inset-0 bg-gradient-to-b from-white/30 to-white"></div>

        <header class="relative z-20">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-8">
                <a href="#home" class="flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 via-sky-400 to-accent-500 text-white shadow-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75m5.25 2.25A8.25 8.25 0 1 1 3.75 12a8.25 8.25 0 0 1 16.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-bold tracking-tight text-slate-900">PsychoCare</div>
                        <div class="text-xs text-slate-500">Aqlli psixolog / psixiatr yordamchisi</div>
                    </div>
                </a>

                <div class="hidden items-center gap-8 md:flex">
                    <a href="#imkoniyatlar"
                        class="text-sm font-medium text-slate-600 transition hover:text-brand-600">Imkoniyatlar</a>
                    <a href="#kimlar-uchun"
                        class="text-sm font-medium text-slate-600 transition hover:text-brand-600">Kimlar uchun</a>
                    <a href="#jarayon" class="text-sm font-medium text-slate-600 transition hover:text-brand-600">Qanday
                        ishlaydi</a>
                    <a href="#faq" class="text-sm font-medium text-slate-600 transition hover:text-brand-600">FAQ</a>
                </div>

                <div class="hidden md:block">
                    <a href="https://t.me/PsychoCareUzBot" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-brand-600">
                        Kirish
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <button id="menuButton"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white/80 p-2 text-slate-700 shadow-sm md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </nav>

            <div id="mobileMenu"
                class="mx-6 hidden rounded-3xl border border-white/70 bg-white/85 p-4 shadow-soft backdrop-blur md:hidden">
                <div class="flex flex-col gap-3">
                    <a href="#imkoniyatlar"
                        class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">Imkoniyatlar</a>
                    <a href="#kimlar-uchun"
                        class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">Kimlar
                        uchun</a>
                    <a href="#jarayon"
                        class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">Qanday
                        ishlaydi</a>
                    <a href="#faq"
                        class="rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">FAQ</a>
                    <a href="https://t.me/PsychoCareUzBot" target="_blank" rel="noopener noreferrer"
                        class="mt-2 inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">
                        Telegram orqali kirish
                    </a>
                </div>
            </div>
        </header>

        <main id="home" class="relative z-10">
            <section
                class="mx-auto grid max-w-7xl items-center gap-12 px-6 pb-24 pt-12 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:pb-28 lg:pt-10">
                <div class="reveal">
                    <div
                        class="mb-5 inline-flex items-center gap-2 rounded-full border border-brand-100 bg-white/70 px-4 py-2 text-sm font-medium text-brand-700 shadow-sm">
                        <span class="inline-block h-2.5 w-2.5 animate-pulse rounded-full bg-emerald-500"></span>
                        Telegram Bot + Mobil ilova
                    </div>

                    <h1
                        class="max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl lg:text-6xl lg:leading-[1.05]">
                        Ruhiy holatni kuzatish,
                        <span
                            class="bg-gradient-to-r from-brand-600 via-sky-500 to-accent-500 bg-clip-text text-transparent">tahlil
                            qilish</span>
                        va shifokor bilan bog‘lash uchun yagona platforma.
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                        PsychoCare — bemor, psixolog va psixiatr o‘rtasidagi jarayonni soddalashtiruvchi aqlli tizim.
                        Kayfiyat monitoringi, testlar, xavfli so‘zlarni aniqlash, dori xavfsizligi va shifokor bilan
                        chat — barchasi bitta joyda.
                    </p>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        <a href="https://t.me/PsychoCareUzBot" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-3 rounded-2xl bg-slate-900 px-7 py-4 text-base font-semibold text-white shadow-glow transition hover:-translate-y-0.5 hover:bg-brand-600">
                            Kirish
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        <a href="#imkoniyatlar"
                            class="inline-flex items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white/80 px-7 py-4 text-base font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:text-brand-700">
                            Imkoniyatlarni ko‘rish
                        </a>
                    </div>

                    <div class="mt-10 grid max-w-2xl grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="glass rounded-2xl p-4 shadow-soft">
                            <div class="text-2xl font-black text-slate-950"><span class="counter"
                                    data-target="9">0</span>/9</div>
                            <div class="mt-1 text-sm text-slate-600">Kayfiyatni tez baholash tizimi</div>
                        </div>
                        <div class="glass rounded-2xl p-4 shadow-soft">
                            <div class="text-2xl font-black text-slate-950"><span class="counter"
                                    data-target="24">0</span>/7</div>
                            <div class="mt-1 text-sm text-slate-600">Telegram eslatmalari va monitoring</div>
                        </div>
                        <div class="glass rounded-2xl p-4 shadow-soft">
                            <div class="text-2xl font-black text-slate-950"><span class="counter"
                                    data-target="3">0</span> daraja</div>
                            <div class="mt-1 text-sm text-slate-600">Risk so‘zlari bo‘yicha ogohlantirish</div>
                        </div>
                    </div>
                </div>

                <div class="reveal relative lg:pl-8">
                    <div
                        class="animate-floaty rounded-[2rem] border border-white/70 bg-white/70 p-4 shadow-glow backdrop-blur-xl">
                        <div class="overflow-hidden rounded-[1.6rem] bg-slate-950 text-white">
                            <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                                <div>
                                    <div class="text-sm font-medium text-slate-300">Bugungi nazorat</div>
                                    <div class="text-xl font-bold">Bemor holati kuzatuvi</div>
                                </div>
                                <div
                                    class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold text-emerald-300">
                                    Faol</div>
                            </div>

                            <div class="grid gap-4 p-5 sm:grid-cols-2">
                                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                    <div class="text-sm text-slate-400">Hozirgi kayfiyat</div>
                                    <div class="mt-2 flex items-end gap-2">
                                        <span class="text-4xl font-black text-white">6</span>
                                        <span class="mb-1 text-sm text-slate-400">/ 9</span>
                                    </div>
                                    <div class="mt-3 h-2 rounded-full bg-white/10">
                                        <div
                                            class="h-2 w-2/3 rounded-full bg-gradient-to-r from-brand-400 to-accent-400">
                                        </div>
                                    </div>
                                    <p class="mt-3 text-sm text-slate-300">“Kayfiyat o‘rtacha, biroz charchoq bor,
                                        lekin nazorat ostida.”</p>
                                </div>

                                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                    <div class="text-sm text-slate-400">Risk tahlili</div>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <span
                                            class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold text-emerald-300">Past</span>
                                        <span
                                            class="rounded-full bg-yellow-500/15 px-3 py-1 text-xs font-semibold text-yellow-300">O‘rta</span>
                                        <span
                                            class="rounded-full bg-rose-500/15 px-3 py-1 text-xs font-semibold text-rose-300">Kritik</span>
                                    </div>
                                    <p class="mt-3 text-sm text-slate-300">Izohlardagi xavfli iboralar shifokorga
                                        avtomatik ko‘rsatiladi.</p>
                                </div>

                                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 sm:col-span-2">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <div class="text-sm text-slate-400">Shifokor paneli</div>
                                            <div class="mt-1 text-lg font-semibold">Trendlar, test natijalari va chat
                                                bir joyda</div>
                                        </div>
                                        <div class="rounded-2xl bg-white/10 px-4 py-2 text-sm text-slate-200">Real-time
                                            kuzatuv</div>
                                    </div>

                                    <div class="mt-4 grid gap-3 sm:grid-cols-3">
                                        <div class="rounded-2xl bg-white/5 p-3">
                                            <div class="text-xs text-slate-400">Mood tracking</div>
                                            <div class="mt-1 font-semibold">Dinamik grafiklar</div>
                                        </div>
                                        <div class="rounded-2xl bg-white/5 p-3">
                                            <div class="text-xs text-slate-400">Clinical tests</div>
                                            <div class="mt-1 font-semibold">Ball va interpretatsiya</div>
                                        </div>
                                        <div class="rounded-2xl bg-white/5 p-3">
                                            <div class="text-xs text-slate-400">Medication safety</div>
                                            <div class="mt-1 font-semibold">Dorilar tekshiruvi</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="absolute -left-6 top-10 hidden h-28 w-28 rounded-full bg-brand-200/50 blur-3xl lg:block">
                    </div>
                    <div
                        class="absolute -bottom-8 right-0 hidden h-36 w-36 rounded-full bg-accent-200/50 blur-3xl lg:block">
                    </div>
                </div>
            </section>
        </main>
    </div>

    <section class="relative z-10 -mt-8 pb-8">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="glass grid gap-4 rounded-[2rem] border border-white/80 p-6 shadow-soft md:grid-cols-3 md:p-8">
                <div class="reveal rounded-3xl bg-slate-50/80 p-6">
                    <div
                        class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-100 text-brand-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h3m-2.25 4.5h4.227c1.213 0 2.318-.69 2.853-1.78l3.192-6.483a1.875 1.875 0 0 0-.168-1.957l-3.614-4.702A1.875 1.875 0 0 0 14.806 4.5H7.313c-.97 0-1.83.625-2.128 1.548L2.445 14.27a1.875 1.875 0 0 0 .22 1.64l3.492 4.602a1.875 1.875 0 0 0 1.503.738Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Bemor uchun qulay</h3>
                    <p class="mt-2 text-sm leading-7 text-slate-600">Mood tracking, testlar, Telegram eslatmalari va
                        shifokor bilan muloqot — sodda va tezkor interfeysda.</p>
                </div>
                <div class="reveal rounded-3xl bg-slate-50/80 p-6">
                    <div
                        class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-accent-100 text-accent-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6.75v-1.5a3.75 3.75 0 1 0-7.5 0v1.5m7.5 0h1.5A2.25 2.25 0 0 1 19.5 9v9a2.25 2.25 0 0 1-2.25 2.25h-10.5A2.25 2.25 0 0 1 4.5 18V9a2.25 2.25 0 0 1 2.25-2.25h1.5m7.5 0h-7.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Shifokor uchun aqlli kuzatuv</h3>
                    <p class="mt-2 text-sm leading-7 text-slate-600">Kayfiyat dinamikasi, test natijalari, xavfli
                        izohlar va bemor profili — barchasi bitta professional panelda.</p>
                </div>
                <div class="reveal rounded-3xl bg-slate-50/80 p-6">
                    <div
                        class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18.75c4.556 0 8.25-2.91 8.25-6.5S16.556 5.75 12 5.75 3.75 8.66 3.75 12.25s3.694 6.5 8.25 6.5Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15a2.75 2.75 0 1 0 0-5.5A2.75 2.75 0 0 0 12 15Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Tizim darajasida nazorat</h3>
                    <p class="mt-2 text-sm leading-7 text-slate-600">Superadmin uchun verifikatsiya, test boshqaruvi,
                        risk so‘zlari va tibbiy ma’lumotlar importi uchun alohida panel.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="imkoniyatlar" class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="reveal mx-auto max-w-3xl text-center">
            <span class="inline-flex rounded-full bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">Asosiy
                imkoniyatlar</span>
            <h2 class="mt-5 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Platformadagi eng muhim
                funksiyalar</h2>
            <p class="mt-4 text-lg leading-8 text-slate-600">PsychoCare ruhiy salomatlik jarayonini kuzatish, tahlil
                qilish va boshqarish uchun tuzilgan zamonaviy ekotizim.</p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <article class="feature-card reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="feature-icon mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-100 text-brand-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 13.5 8.25 9l3 3 5.25-6.75 3.75 4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 19.5h16.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Kayfiyat dinamikasi</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">1–9 ballik tizim, bemorning shaxsiy tavsiflari, vaqtga
                    va ob-havoga bog‘liq kontekstual tahlil.</p>
            </article>

            <article class="feature-card reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="feature-icon mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-accent-100 text-accent-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5.25h6m-7.5 4.5h9m-9 4.5h6m-7.5 4.5h9" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Psixologik testlar</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Kategoriya → test → bo‘lim → savol → javob varianti
                    iyerarxiyasi, ballash va interpretatsiya bilan.</p>
            </article>

            <article class="feature-card reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="feature-icon mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-100 text-rose-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.59 14.37a5.25 5.25 0 1 0-7.18 0L12 18l3.59-3.63Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5h.008v.008H12V10.5Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Risk so‘zlari aniqlash</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Izohlardagi past, o‘rta va kritik xavf iboralari
                    aniqlanib, shifokorga bildirishnoma yuboriladi.</p>
            </article>

            <article class="feature-card reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="feature-icon mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25v7.5A2.25 2.25 0 0 1 18.75 18H5.25A2.25 2.25 0 0 1 3 15.75v-7.5M21 8.25l-7.693 4.808a2.25 2.25 0 0 1-2.614 0L3 8.25M21 8.25A2.25 2.25 0 0 0 18.75 6H5.25A2.25 2.25 0 0 0 3 8.25" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Telegram eslatmalari</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Bemor o‘zi tanlagan soatlarda mood kiritish uchun
                    eslatma oladi va bot orqali tez javob bera oladi.</p>
            </article>

            <article class="feature-card reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="feature-icon mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 10.5h9m-9 3h6m-8.25 6h13.5A2.25 2.25 0 0 0 21 17.25V6.75A2.25 2.25 0 0 0 18.75 4.5H5.25A2.25 2.25 0 0 0 3 6.75v10.5A2.25 2.25 0 0 0 5.25 19.5Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Shifokor bilan chat</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Tanlangan psixolog yoki psixiatr bilan
                    to‘g‘ridan-to‘g‘ri muloqot, savollar va tavsiyalar uchun qulay kanal.</p>
            </article>

            <article class="feature-card reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="feature-icon mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-100 text-violet-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 12c0 3.728-3.358 6.75-7.5 6.75S4.5 15.728 4.5 12 7.858 5.25 12 5.25 19.5 8.272 19.5 12Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 2.25v3m0 13.5v3m9.75-9.75h-3m-13.5 0h-3" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Dori xavfsizligi</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Dorilarni almashtirish, qo‘shish, kamaytirish va
                    o‘zaro interaksiyalar bo‘yicha ma’lumotlar bazasi.</p>
            </article>
        </div>
    </section>

    <section id="kimlar-uchun" class="bg-slate-950 py-20 text-white">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="reveal max-w-3xl">
                <span class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-sky-300">Kimlar
                    uchun</span>
                <h2 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">Har bir rol uchun alohida qiymat</h2>
                <p class="mt-4 text-lg leading-8 text-slate-300">Platforma faqat bir tomon uchun emas — bemor, shifokor
                    va boshqaruvchi uchun ham aniq foyda beradi.</p>
            </div>

            <div class="mt-14 grid gap-6 lg:grid-cols-3">
                <div class="reveal rounded-[2rem] border border-white/10 bg-white/5 p-7">
                    <div
                        class="mb-5 inline-flex rounded-2xl bg-brand-500/15 px-4 py-2 text-sm font-semibold text-brand-300">
                        Patient</div>
                    <h3 class="text-2xl font-bold">Bemor</h3>
                    <ul class="mt-5 space-y-3 text-sm leading-7 text-slate-300">
                        <li>• Kayfiyatni tez va qulay kiritish</li>
                        <li>• Telegram eslatmalari orqali nazoratni yo‘qotmaslik</li>
                        <li>• Testlar yechish va natijalarni ko‘rish</li>
                        <li>• Tanlangan shifokor bilan yozishish</li>
                        <li>• Dori xavfsizligi bo‘yicha ma’lumot olish</li>
                    </ul>
                </div>
                <div class="reveal rounded-[2rem] border border-white/10 bg-white/5 p-7">
                    <div
                        class="mb-5 inline-flex rounded-2xl bg-accent-500/15 px-4 py-2 text-sm font-semibold text-accent-300">
                        Doctor</div>
                    <h3 class="text-2xl font-bold">Psixolog / psixiatr</h3>
                    <ul class="mt-5 space-y-3 text-sm leading-7 text-slate-300">
                        <li>• Bemor dinamikasini vaqt bo‘yicha ko‘rish</li>
                        <li>• Xavfli izohlardan tez xabardor bo‘lish</li>
                        <li>• Test natijalarini chuqur tahlil qilish</li>
                        <li>• Anamnez va bemor tarixi bir joyda</li>
                        <li>• Chat orqali tezkor aloqa</li>
                    </ul>
                </div>
                <div class="reveal rounded-[2rem] border border-white/10 bg-white/5 p-7">
                    <div
                        class="mb-5 inline-flex rounded-2xl bg-emerald-500/15 px-4 py-2 text-sm font-semibold text-emerald-300">
                        Superadmin</div>
                    <h3 class="text-2xl font-bold">Tizim boshqaruvi</h3>
                    <ul class="mt-5 space-y-3 text-sm leading-7 text-slate-300">
                        <li>• Shifokor verifikatsiyasini nazorat qilish</li>
                        <li>• Testlar va risk so‘zlarini boshqarish</li>
                        <li>• Importlar va tibbiy bilim bazasini yangilash</li>
                        <li>• Foydalanuvchi va faollik statistikasi</li>
                        <li>• Xavfsiz, rollarga bo‘lingan access nazorati</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="jarayon" class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="reveal mx-auto max-w-3xl text-center">
            <span class="inline-flex rounded-full bg-accent-50 px-4 py-2 text-sm font-semibold text-accent-700">Qanday
                ishlaydi</span>
            <h2 class="mt-5 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">4 oddiy qadam bilan boshlang
            </h2>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div class="reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-lg font-black text-white">
                    1</div>
                <h3 class="text-xl font-bold text-slate-900">Telegram orqali kiring</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Bot orqali ro‘yxatdan o‘ting va profilingizni bir
                    necha daqiqada faollashtiring.</p>
            </div>
            <div class="reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-600 text-lg font-black text-white">
                    2</div>
                <h3 class="text-xl font-bold text-slate-900">Ma’lumotlaringizni to‘ldiring</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Bemor bo‘lsangiz anamnez, shifokor bo‘lsangiz
                    verifikatsiya formasi orqali tizimni to‘liq ishga tushiring.</p>
            </div>
            <div class="reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-accent-600 text-lg font-black text-white">
                    3</div>
                <h3 class="text-xl font-bold text-slate-900">Kuzatuvni boshlang</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Kayfiyat kiriting, testlar yeching, eslatmalarni
                    sozlang va shifokorni tanlang.</p>
            </div>
            <div class="reveal rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-soft">
                <div
                    class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-600 text-lg font-black text-white">
                    4</div>
                <h3 class="text-xl font-bold text-slate-900">Aqlli nazoratni yoqing</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">Trendlar, ogohlantirishlar, test natijalari va chat
                    orqali holatni izchil olib boring.</p>
            </div>
        </div>
    </section>

    <section class="px-6 pb-20 lg:px-8">
        <div
            class="mx-auto max-w-7xl overflow-hidden rounded-[2.2rem] bg-gradient-to-r from-slate-950 via-brand-900 to-accent-900 p-8 text-white shadow-glow md:p-12">
            <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">
                <div class="reveal max-w-3xl">
                    <span
                        class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-sky-300">Boshlashga
                        tayyormisiz?</span>
                    <h2 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">Ruhiy holat nazoratini zamonaviy
                        darajaga olib chiqing.</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-200">PsychoCare yordamida bemorlar kuzatuvni
                        yo‘qotmaydi, shifokorlar esa ko‘proq aniq signal va qulay boshqaruvga ega bo‘ladi.</p>
                </div>
                <div class="reveal">
                    <a href="https://t.me/PsychoCareUzBot" target="_blank" rel="noopener noreferrer"
                        class="inline-flex animate-pulseSoft items-center justify-center gap-3 rounded-2xl bg-white px-8 py-4 text-base font-bold text-slate-950 transition hover:-translate-y-0.5 hover:bg-sky-50">
                        Kirish
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="mx-auto max-w-5xl px-6 pb-20 lg:px-8">
        <div class="reveal text-center">
            <span
                class="inline-flex rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">FAQ</span>
            <h2 class="mt-5 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Ko‘p so‘raladigan savollar
            </h2>
        </div>

        <div class="mt-12 space-y-4">
            <details class="reveal group rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
                <summary class="cursor-pointer list-none text-lg font-semibold text-slate-900">PsychoCare kimlar uchun
                    mo‘ljallangan?</summary>
                <p class="mt-4 text-sm leading-7 text-slate-600">Ruhiy holatini kuzatib borishni istagan bemorlar, o‘z
                    bemorlarini tizimli ko‘rishni xohlagan psixolog va psixiatrlar, hamda platformani boshqaruvchi
                    administratorlar uchun.</p>
            </details>
            <details class="reveal group rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
                <summary class="cursor-pointer list-none text-lg font-semibold text-slate-900">Mood tracking qanday
                    ishlaydi?</summary>
                <p class="mt-4 text-sm leading-7 text-slate-600">Bemor kayfiyatini 1 dan 9 gacha baholaydi, istasa izoh
                    qoldiradi. Tizim vaqt, trend va boshqa kontekstlarni hisobga olib ma’lumotni shifokor panelida
                    chiroyli ko‘rsatadi.</p>
            </details>
            <details class="reveal group rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
                <summary class="cursor-pointer list-none text-lg font-semibold text-slate-900">Telegram orqali ham
                    foydalanish mumkinmi?</summary>
                <p class="mt-4 text-sm leading-7 text-slate-600">Ha. Telegram bot orqali ro‘yxatdan o‘tish, eslatma
                    olish va kayfiyat belgilash imkoniyati mavjud.</p>
            </details>
            <details class="reveal group rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
                <summary class="cursor-pointer list-none text-lg font-semibold text-slate-900">Dori bo‘limi shifokor
                    tavsiyasini almashtiradimi?</summary>
                <p class="mt-4 text-sm leading-7 text-slate-600">Yo‘q. Bu bo‘lim ma’lumotnoma xarakteriga ega bo‘lib,
                    klinik qaror o‘rnini bosa olmaydi. Har qanday dori bilan bog‘liq qaror mutaxassis nazorati ostida
                    qabul qilinishi kerak.</p>
            </details>
        </div>
    </section>

    <footer class="border-t border-slate-200 bg-slate-50">
        <div
            class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-10 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <div>
                <div class="text-xl font-black tracking-tight text-slate-950">PsychoCare</div>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">Aqlli psixolog va psixiatr yordamchisi.
                    Monitoring, testlar, ogohlantirishlar va shifokor-bemor o‘rtasidagi uzviy aloqa uchun zamonaviy
                    yechim.</p>
            </div>
            <div class="flex flex-col items-start gap-3 lg:items-end">
                <a href="https://t.me/PsychoCareUzBot" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">Kirish</a>
                <p class="text-xs text-slate-500">© <span id="year"></span> PsychoCare. Barcha huquqlar
                    himoyalangan.</p>
            </div>
        </div>
    </footer>

    <script>
        const menuButton = document.getElementById('menuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        if (menuButton) {
            menuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
        });

        const reveals = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });

        reveals.forEach((el) => revealObserver.observe(el));

        const counters = document.querySelectorAll('.counter');
        const runCounter = (el) => {
            const target = Number(el.dataset.target || 0);
            const duration = 1200;
            const startTime = performance.now();

            const step = (now) => {
                const progress = Math.min((now - startTime) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target);
                if (progress < 1) requestAnimationFrame(step);
                else el.textContent = target;
            };

            requestAnimationFrame(step);
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    runCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach((counter) => counterObserver.observe(counter));

        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>

</html>
