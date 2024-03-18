<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
            tampung semua data transaction kedalam variabel $transactions, kemudian kita memanggil relasi menggunakan with,
            disini kita juga menambahkan method search yang kita dapatkan dari sebuah trait hasScope,
            selanjutnya kita pecah data transaction yang kita tampilkan hanya 10 per halaman dengan urutan terbaru.
        */
        $transactions = Transaction::with('details.course', 'user')
                ->latest()
                ->search('status')
                ->paginate(10)
                ->withQueryString();

        // jumlahkan "grand_total" dari variabel $transactions kemudian tampung data tersebut kedalam variabel $grandTotal.
        $grandTotal = $transactions->sum('grand_total');

        // passing variabel $transactions dan $grandTotal kedalam view.
        return view('admin.transaction.index', compact('transactions', 'grandTotal'));
    }

    public function show(Transaction $transaction)
    {
        // tampung data transaction detail kedalam variabel $orders, yang dimana "transaction_id"nya sama dengan variabel $transaction->id.
        $orders = TransactionDetail::with('transaction', 'course')
            ->where('transaction_id', $transaction->id)
            ->get();

        // ambil data "snap_token" dari variabel $transactions kemudian tampung data tersebut kedalam variabel $snapToken.
        $snapToken = $transaction->snap_token;

        // jumlahkan "price" dari variabel $orders kemudian tampung data tersebut kedalam variabel $grandTotal.
        $grandTotal = $orders->sum('price');

        // passing variabel $orders, $grandTotal, $transaction, dan $snapToken kedalam view.
        return view('admin.transaction.show', compact('orders', 'grandTotal', 'transaction', 'snapToken'));
    }
}
