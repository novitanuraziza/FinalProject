@extends('layouts.frontend.app', ['title' => 'Checkout'])

@section('content')
    <div class="w-full p-6 md:p-12 bg-slate-700 h-full">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center justify-center gap-y-4 md:gap-y-8 text-center">
                <img src="{{ asset('pay.svg') }}" class="w-1/2 md:w-1/3 object-cover object-center">
                <h1 class="text-gray-100 font-semibold text-lg md:text-2xl mx-0 md:mx-80">
                    Pesanan anda telah kami konfirmasi, Silahkan lanjutkan dengan melakukan
                    pembayaran
                </h1>
                <button
                    class="px-4 py-2 rounded-lg bg-red-800 text-white hover:scale-110 hover:duration-200 flex items-center gap-2 text-sm border"
                    id="pay-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wallet mr-1" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12">
                        </path>
                        <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                    </svg>
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.serverKey') }}"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function() {
                    window.location.href = "{{ route('home') }}";
                },
                // Optional
                onPending: function() {
                    window.location.href = "{{ route('home') }}";
                },
                // Optional
                onError: function() {
                    window.location.href = "{{ route('home') }}";
                }
            });
        });
    </script>
@endpush
