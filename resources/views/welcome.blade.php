<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Employee Management System portfolio demonstration.">
        <title>Employee Management System</title>
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-white">
        <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-16">
            <img src="{{ asset('images/employee-management-background.svg') }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-40">
            <div class="absolute inset-0 bg-slate-950/70"></div>
            <section class="relative z-10 w-full max-w-2xl rounded-3xl border border-white/15 bg-white/10 p-8 text-center shadow-2xl backdrop-blur sm:p-12">
                <img src="{{ asset('images/employee-management-logo.svg') }}" class="mx-auto h-20 w-20" alt="Employee Management System logo">
                <p class="mt-6 text-sm font-semibold uppercase tracking-[0.25em] text-sky-200">Portfolio Demo</p>
                <h1 class="mt-3 text-4xl font-bold tracking-tight">Employee Management System</h1>
                <p class="mx-auto mt-4 max-w-xl text-slate-200">
                    A web application for employee records, attendance, leave, overtime, reporting, and administrative workflows.
                </p>
                <p class="mx-auto mt-5 max-w-xl text-sm leading-relaxed text-slate-300">
                    All names, records, locations, and business data in this application are fictional and intended for demonstration purposes only.
                </p>
                @if (Route::has('login'))
                    <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="mt-8 inline-flex rounded-xl bg-sky-500 px-5 py-3 font-semibold text-white transition hover:bg-sky-400">
                        {{ auth()->check() ? 'Open Dashboard' : 'Open Local Demo' }}
                    </a>
                @endif
            </section>
        </main>
    </body>
</html>
