@extends('layouts.backend.app', ['title' => 'Transaction Detail'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h1 class="card-title">
                        DETAIL TRANSACTION
                    </h1>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="30%">No.Invoice</td>
                                <td>
                                    {{ $transaction->invoice }}
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Nama Lengkap</td>
                                <td>
                                    {{ $transaction->user->name }}
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Email</td>
                                <td>
                                    {{ $transaction->user->email }}
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Status</td>
                                <td>
                                    @if ($transaction->status == 'success')
                                        <button class="btn btn-primary btn-sm" disabled>
                                            Pembayaran Telah Diverifikasi Sistem
                                        </button>
                                    @elseif($transaction->status == 'pending')
                                        <button id="pay-button" class="btn btn-danger btn-sm">
                                            Lanjutkan Pembayaran
                                        </button>
                                    @else
                                        <button class="btn btn-warning btn-sm" disabled>
                                            Silahkan Lakukan Order Kembali
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Tanggal Pembelian</td>
                                <td>
                                    {{ $transaction->created_at->format('d M Y H:i:s') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h1 class="card-title">
                        DETAIL ITEMS
                    </h1>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th class="text-right">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        {{ $order->course->name }}
                                    </td>
                                    <td class="text-right">
                                        <sup>Rp</sup> {{ moneyFormat($order->price) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="font-weight-bold">Total</td>
                                <td class="text-right text-success">
                                    <sup>Rp</sup> {{ moneyFormat($grandTotal) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        })
    </script>
@endpush
