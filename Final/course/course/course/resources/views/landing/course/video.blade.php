@extends('layouts.frontend.app', ['title' => 'Homepage'])

@section('content')
    <div class="w-full bg-slate-700 p-5 md:p-20">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-4">
                <div class="col-span-12 md:col-span-7">
                    <div class="aspect-w-16 aspect-h-8 md:aspect-w-12 md:aspect-h-8 border rounded-lg">
                        <iframe src="https://www.youtube.com/embed/{{ $video->video_code }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen class="rounded-lg"></iframe>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-5">
                    <div class="p-0 md:p-4">
                        <h1 class="text-white text-base font-semibold">{{ $course->name }}</h1>
                        <p class="text-sm text-gray-400 mb-2 text-justify mt-1">
                            {{ $course->description }}
                        </p>
                        <div class="flex flex-row items-center justify-end gap-2 pb-5 mt-5">
                            <p class="text-xs text-gray-400">{{ $course->videos->count() }} Episodes</p>
                            <a href="" class="text-xs text-gray-400 underline hover:text-blue-400">
                                {{ $course->category->name }}
                            </a>
                            <div class="flex items-center text-xs text-yellow-500 gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-star w-3 h-3 fill-yellow-500" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                                    </path>
                                </svg>
                                {{ round($avgRating, 1) }} ( {{ $course->reviews->count() }} Rating )
                            </div>
                        </div>
                        <div class="h-52 md:h-80 overflow-y-auto">
                            @foreach ($videos as $video)
                                <div class="p-4 text-gray-100 {{ videoActive($video->episode) }}">
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('course.video', [$course->slug, $video->episode]) }}"
                                            class="flex flex-row items-center">
                                            @if (videoActive($video->episode))
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-player-play w-5 h-5 text-green-500 fill-green-500"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M7 4v16l13 -8z"></path>
                                                </svg>
                                            @endif
                                            <p class="text-xs md:text-sm ml-2 hover:text-red-500">
                                                {{ $video->episode }}. {{ $video->name }}
                                            </p>
                                        </a>
                                        <div class="text-xs md:text-sm">
                                            @if ($video->intro == 0)
                                                @if ($alreadyBought)
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-rocket w-5 h-5 text-blue-500 fill-white"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.25" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3">
                                                        </path>
                                                        <path d="M7 14a6 6 0 0 0 -3 6a6 6 0 0 0 6 -3"></path>
                                                        <circle cx="15" cy="9" r="1"></circle>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-lock-open w-5 h-5"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.25" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <rect x="5" y="11" width="14" height="10"
                                                            rx="2"></rect>
                                                        <circle cx="12" cy="16" r="1"></circle>
                                                        <path d="M8 11v-5a4 4 0 0 1 8 0"></path>
                                                    </svg>
                                                @endif
                                            @else
                                                @if ($alreadyBought)
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-rocket w-5 h-5 text-blue-500 fill-white"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.25" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3">
                                                        </path>
                                                        <path d="M7 14a6 6 0 0 0 -3 6a6 6 0 0 0 6 -3"></path>
                                                        <circle cx="15" cy="9" r="1"></circle>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-lock text-red-500 w-5 h-5"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.25" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <rect x="5" y="11" width="14"
                                                            height="10" rx="2"></rect>
                                                        <circle cx="12" cy="16" r="1"></circle>
                                                        <path d="M8 11v-4a4 4 0 0 1 8 0v4"></path>
                                                    </svg>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="p-4 flex justify-end gap-2">
                        <a href="#review"
                            class="px-4 py-2 rounded-lg bg-cyan-800 text-white flex items-center gap-2 text-sm border border-cyan-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-2 w-5 h-5"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 20l-3 -3h-2a3 3 0 0 1 -3 -3v-6a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-2l-3 3">
                                </path>
                                <line x1="8" y1="9" x2="16" y2="9"></line>
                                <line x1="8" y1="13" x2="14" y2="13"></line>
                            </svg>
                            {{ $course->reviews->count() }} Review
                        </a>
                        @if ($alreadyBought)
                            <div
                                class="px-4 py-2 rounded-lg bg-sky-800 text-white flex items-center gap-2 text-sm border cursor-not-allowed border-sky-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-discount-check w-5 h-5" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1">
                                    </path>
                                    <path d="M9 12l2 2l4 -4"></path>
                                </svg>
                                Premium Akses
                            </div>
                        @else
                            <form action="{{ route('cart.store', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-green-800 text-white flex items-center gap-2 text-sm border border-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-basket w-5 h-5" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <polyline points="7 10 12 4 17 10"></polyline>
                                        <path d="M21 10l-2 8a2 2.5 0 0 1 -2 2h-10a2 2.5 0 0 1 -2 -2l-2 -8z"></path>
                                        <circle cx="12" cy="15" r="2"></circle>
                                    </svg>
                                    Beli Sekarang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="review" class="w-full bg-gray-800 border-t border-b p-5 md:p-20 border-dashed border-slate-700">
        <div class="container mx-auto">
            <div class="p-4">
                <div class="flex flex-col gap-2 text-center items-center mb-10">
                    <h1 class="text-2xl text-white font-semibold">Review</h1>
                    <p class="text-sm text-gray-400 lg:mx-96">
                        Kumpulan review dari para member yang telah membeli course ini
                    </p>
                    <div class="w-60 bg-gray-700 h-1 mt-2"></div>
                </div>
                <div class="flex flex-row overflow-x-auto md:grid md:grid-cols-3 gap-4 items-start">
                    @foreach ($reviews as $review)
                        <div class="min-w-full bg-slate-800 rounded-lg border border-slate-600">
                            <div class="flex justify-between p-4">
                                <div class="flex space-x-4">
                                    <div>
                                        <img src="{{ $review->user->avatar }}" alt=""
                                            class="object-cover w-12 h-12 rounded-full border">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white">{{ $review->user->name }}</h4>
                                        <span class="text-xs text-gray-400">
                                            {{ $review->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-star fill-yellow-500 w-5 h-5" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                                        </path>
                                    </svg>
                                    <span class="text-xl font-bold">
                                        {{ $review->rating }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 space-y-2 text-sm text-gray-300 border-t border-dashed border-slate-700">
                                <p class="text-justify">{{ $review->review }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
