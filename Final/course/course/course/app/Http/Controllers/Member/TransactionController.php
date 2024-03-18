<?php

namespace App\Http\Controllers\Member;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        /*
            tampung semua data transaction yang dimiliki oleh user yang sedang login kedalam variabel $transactions, kemudian kita memanggil relasi menggunakan with, selanjutnya kita pecah data transaction yang kita tampilkan hanya 10 per halaman dengan urutan terbaru.
        */
        $transactions = Transaction::with('details')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        // passing variabel $transactions kedalam view.
        return view('member.transaction.index', compact('transactions'));
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
        return view('member.transaction.show', compact('orders', 'snapToken', 'grandTotal', 'transaction'));
    }
}
