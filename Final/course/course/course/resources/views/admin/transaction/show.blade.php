@extends('layouts.backend.app', ['title' => 'Transaction Detail'])

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card title="DETAIL TRANSACTION">
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
                                    <button class="btn btn-primary btn-sm" disabled>Pembayaran Telah Diverifikasi
                                        Sistem</button>
                                @elseif($transaction->status == 'pending')
                                    <button id="pay-button" class="btn btn-info btn-sm">
                                        Lanjutkan Pembayaran
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-sm" disabled>
                                        pembayaran untuk pesanan Anda sudah kedaluwarsa
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
            </x-card>
        </div>
        <div class="col-12">
            <x-card title="DETAIL ITEMS">
                <table class="table">
                    <thead>
                        <tr>
                            <th>COURSE</th>
                            <th class="text-right">PRICE</th>
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
                            <td class="font-weight-bold">GRAND TOTAL</td>
                            <td class="text-right text-success font-weight-bold">
                                <sup>Rp</sup> {{ moneyFormat($grandTotal) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </x-card>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.serverKey') }}"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $snapToken }}');
        });
    </script>
@endpush
