<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <div class="min-h-screen relative overflow-hidden bg-slate-950 text-slate-100">
        <Head v-if="title" :title="title" />

        <div class="absolute inset-0">
            <img src="/images/employee-management-background.svg" alt="Abstract employee management background" class="w-full h-full object-cover opacity-40" />
        </div>

        <div class="absolute inset-0 bg-gradient-to-br from-slate-950/80 via-slate-900/70 to-blue-950/70" />
        <div class="absolute inset-0 backdrop-blur-[2px]" />

        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="w-full max-w-5xl">
                <div
                    class="overflow-hidden rounded-3xl bg-white/10 ring-1 ring-white/15 shadow-2xl shadow-blue-950/40 backdrop-blur"
                >
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <!-- Left / Branding -->
                        <div class="relative px-8 py-10 sm:px-12 lg:py-14">
                            <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 via-white/0 to-blue-950/25" />
                            <div class="relative">
                                <div class="flex items-center gap-3">
                                    <img src="/images/employee-management-logo.svg" class="h-12 w-12" alt="Employee Management System logo" />
                                    <div>
                                        <div class="text-sm font-semibold tracking-wide text-slate-100/90">Employee Management System</div>
                                        <div class="text-xs text-slate-200/80">Portfolio Demo</div>
                                    </div>
                                </div>

                                <div class="mt-10">
                                    <slot name="heading">
                                        <h1 class="text-3xl font-semibold tracking-tight text-white">Selamat Datang</h1>
                                        <p class="mt-3 max-w-md text-sm leading-relaxed text-slate-200/90">
                                            Employee operations for attendance, leave, overtime, records, and reporting.
                                        </p>
                                    </slot>
                                </div>

                                <div class="mt-10 hidden lg:block">
                                    <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-5">
                                        <div class="text-xs font-semibold text-slate-100/90">Akses Sistem</div>
                                        <div class="mt-1 text-xs text-slate-200/80">
                                            Akun dibuat oleh administrator. Jika belum memiliki akses, hubungi admin.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right / Form -->
                        <div class="px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                            <slot />

                            <div class="mt-6 text-center text-sm text-slate-200/90">
                                <slot name="footer" />
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mx-auto mt-5 max-w-3xl text-center text-xs leading-relaxed text-slate-300/90">
                    Portfolio Demo — All names, records, locations, and business data in this application are fictional and intended for demonstration purposes only.
                </p>
            </div>
        </div>
    </div>
</template>
