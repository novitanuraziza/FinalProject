@extends('layouts.frontend.app', ['title' => 'Homepage'])

@section('content')
    @include('layouts.frontend.partials.hero')
    <section
        class="p-8 text-center bg-slate-800 font-semibold text-white text-lg md:text-2xl border-t border-b border-dashed border-slate-700">
        <span class="text-red-500">{{ $user->count() }}</span> ORANG TELAH BELAJAR KURSUS DI LARADEV
    </section>
    <section class="bg-slate-600 p-10 w-full">
        <div class="flex flex-col gap-2 text-center items-center mb-10">
            <h1 class="text-2xl text-white font-semibold">COURSE</h1>
            <p class="text-sm text-gray-400 lg:mx-96">
                Kami menyediakan berbagai macam pembahasan dengan studi kasus yang dapat membantu menjadi seorang Developer
                Profesional.
            </p>
            <div class="w-60 bg-slate-800 h-1 mt-2"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 container mx-auto my-5 items-start">
            @foreach ($courses as $course)
                <x-landing.course-item :course="$course" />
            @endforeach
        </div>
        <div class="flex justify-center text-center mt-14">
            <a href="{{ route('course.index') }}"
                class="px-4 py-2 rounded-lg bg-slate-800 text-white hover:bg-red-800 hover:duration-200 flex items-center gap-2 text-lg border border-slate-500 hover:border-red-600 hover:transition-colors">
                Lihat Semua Course
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right w-5 h-5"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <line x1="15" y1="16" x2="19" y2="12"></line>
                    <line x1="15" y1="8" x2="19" y2="12"></line>
                </svg>
            </a>
        </div>
    </section>
    <section class="w-full p-6 bg-gray-800 border-t border-b border-dashed border-gray-700">
        <div class="flex flex-col items-center justify-center p-4 space-y-8 md:p-10 md:px-24 xl:px-48">
            <h1 class="text-2xl md:text-3xl font-bold leading-none text-center text-white">
                TUNGGU APA LAGI ?
            </h1>
            <p class="text-sm md:text-base font-medium text-center text-gray-400">
                Belajar lebih terarah dan sistematis dengan materi berkualitas
                tinggi beserta pendampingan mentoring secara intensif.
            </p>
            <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:space-x-8">
                <a href="{{ route('register') }}"
                    class="px-4 py-2 rounded-lg bg-slate-700 text-white text-base flex items-center gap-2 hover:scale-110 hover:duration-200 border border-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        <path d="M16 11h6m-3 -3v6"></path>
                    </svg>
                    Daftar Gratis!
                </a>
            </div>
        </div>
    </section>
@endsection
