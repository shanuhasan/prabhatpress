<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Prabhat Printing Press</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-ink antialiased bg-white">
    <div class="min-h-screen grid lg:grid-cols-2">

        <!-- Brand panel -->
        <aside
            class="relative hidden lg:flex flex-col justify-between overflow-hidden bg-gradient-to-br from-navy-700 via-navy-800 to-navy-900 p-12 text-white">
            <!-- Decorative rings + glow -->
            <div class="pointer-events-none absolute -right-32 -top-32 h-[28rem] w-[28rem] rounded-full bg-gold-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-40 -left-24 h-[26rem] w-[26rem] rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-8 h-[18rem] w-[18rem] rounded-full border border-white/10"></div>

            <div class="relative flex items-center gap-3">
                <span
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-gold-300 via-gold-500 to-gold-600 text-base font-extrabold text-navy-900 shadow-lg shadow-gold-500/30">PP</span>
                <div class="leading-tight">
                    <div class="text-lg font-bold tracking-[0.08em]">PRABHAT</div>
                    <div class="text-[0.7rem] uppercase tracking-[0.2em] text-slate-400">Printing Press</div>
                </div>
            </div>

            <div class="relative max-w-md">
                <p class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gold-400">Order &amp; accounts</p>
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight">
                    Every order, payment and rupee &mdash; in one place.
                </h2>
                <p class="mt-5 text-base leading-relaxed text-slate-300">
                    Track jobs from booking to delivery, record cash and online payments, and see today's
                    collection at a glance.
                </p>

                <ul class="mt-8 space-y-3 text-sm text-slate-300">
                    <li class="flex items-center gap-3">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/10 text-gold-400">&check;</span>
                        Orders, customers and suppliers
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/10 text-gold-400">&check;</span>
                        Daily received, expenses and net collection
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/10 text-gold-400">&check;</span>
                        Yearly reports by account
                    </li>
                </ul>
            </div>

            <p class="relative text-xs text-slate-500">&copy; 2023&ndash;{{ date('Y') }} Prabhat Printing Press</p>
        </aside>

        <!-- Form panel -->
        <main class="flex items-center justify-center bg-slate-50 px-6 py-12 sm:px-10">
            <div class="w-full max-w-md">
                <!-- Compact brand for small screens -->
                <div class="mb-8 flex items-center gap-3 lg:hidden">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-gold-300 via-gold-500 to-gold-600 text-sm font-extrabold text-navy-900">PP</span>
                    <div class="leading-tight">
                        <div class="font-bold tracking-[0.08em]">PRABHAT</div>
                        <div class="text-[0.65rem] uppercase tracking-[0.2em] text-slate-500">Printing Press</div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/60 sm:p-10">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
