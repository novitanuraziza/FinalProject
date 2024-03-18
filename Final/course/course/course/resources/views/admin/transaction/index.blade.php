@extends('layouts.backend.app', ['title' => 'Transaction'])

@section('content')
    <div class="row">
        <div class="col-12">
            <x-input-search :url="route('admin.transaction.index')" placeholder="Search status.." />
        </div>
        <div class="col-12">
            <x-card title="LIST TRANSACTION">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>INVOICE</th>
                            <th>EMAIL</th>
                            <th>TOTAL</th>
                            <th>STATUS</th>
                            <th>DATE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $i => $transaction)
                            <tr>
                                <td>{{ $transactions->firstItem() + $i }}</td>
                                <td>{{ $transaction->invoice }}</td>
                                <td>{{ $transaction->user->email }}</td>
                                <td>
                                    <sup>Rp</sup> {{ moneyFormat($transaction->grand_total) }}
                                </td>
                                <td>
                                    @if ($transaction->status == 'pending')
                                        <span class="badge badge-danger">{{ $transaction->status }}</span>
                                    @elseif($transaction->status == 'success')
                                        <span class="badge badge-success">{{ $transaction->status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $transaction->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.transaction.show', $transaction->id) }}"
                                        class="btn btn-primary btn-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-card>
            <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>
        </div>
    </div>
@endsection
