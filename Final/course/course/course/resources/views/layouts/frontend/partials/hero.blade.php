<div class="w-full py-10 text-white bg-slate-700">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="col-span-12 md:col-span-7 flex flex-col gap-4 lg:gap-8">
                <h1
                    class="text-center md:text-start text-2xl font-semibold md:text-6xl text-gray-50 flex items-center justify-center md:justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-brand-tabler w-10 h-10 md:w-20 md:h-20" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8 9l3 3l-3 3"></path>
                        <line x1="13" y1="15" x2="16" y2="15"></line>
                        <rect x="4" y="4" width="16" height="16" rx="4"></rect>
                    </svg>
                    LaraDev
                </h1>
                <p class="text-sm md:text-lg text-center md:text-start text-gray-100">
                    Website Belajar Coding bahasa Indonesia terlengkap dan mudah dipahami, seperti
                    <span class="underline text-[#F55246]">Laravel</span>,
                    <span class="text-[#41B883] underline">Vue</span>,
                    <span class="text-[#00D8FF] underline">React</span>,
                    <span class="text-[#0BA5E9] underline">Tailwind CSS</span> dan
                    <span class="underline text-blue-500">banyak lagi</span>.
                </p>
                <div class="flex flex-row gap-4 items-center justify-center md:justify-start">
                    <a href="{{ route('course.index') }}"
                        class="px-4 py-2 rounded-lg bg-cyan-800 text-white hover:scale-110 hover:duration-200 flex items-center gap-2 text-sm border border-cyan-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-device-laptop w-5 h-5" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="3" y1="19" x2="21" y2="19"></line>
                            <rect x="5" y="6" width="14" height="10" rx="1"></rect>
                        </svg>
                        Lihat Course
                    </a>
                    <a href="{{ route('showcase') }}"
                        class="px-4 py-2 rounded-lg bg-red-800 text-white hover:scale-110 hover:duration-200 flex items-center gap-2 text-sm border border-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-source-code w-5 h-5"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14.5 4h2.5a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3v-5"></path>
                            <path d="M6 5l-2 2l2 2"></path>
                            <path d="M10 9l2 -2l-2 -2"></path>
                        </svg>
                        Lihat Showcase
                    </a>
                </div>
            </div>
            <div class="hidden md:flex md:col-span-5">
                <img src="{{ asset('learn.svg') }}" class="object-cover">
            </div>
        </div>
    </div>
</div>
