<?php

namespace App\Http\Controllers\Landing;

use Midtrans\Snap;
use App\Models\Cart;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\NewTransaction;
use Illuminate\Support\Facades\Notification;

class CheckoutContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function store(Request $request)
    {
        // gunakan db transaction jika terdapat 2 atau lebih transaksi database yang terjadi.
        $snapToken = DB::transaction(function () use($request){
            // masukan nilai 6 kedalam variabel $length.
            $length = 6;
            // masukan empty string kedalam variabel $random.
            $random = '';
            // lakukan perulangan jika $i kurang dari variabel $legth atau 6 maka tambah nilai varibel $i hingga memiliki nilai 6.
            for ($i = 0; $i < $length; $i++) {
                // tampung hasil random kedalam variabel $random.
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            // tampung hasil data variabel $random kedalam variabel $no_invoice.
            $no_invoice = 'LD-'.Str::upper($random);

            // masukan data transaction baru kemudian tampung kedalam variabel $invoice.
            $invoice = Transaction::create([
                'invoice'           => $no_invoice,
                'user_id'           => $request->user()->id,
                'name'              => $request->name,
                'grand_total'       => $request->grand_total,
                'status'            => 'pending',
            ]);

            // tampung data cart dari user yang sedang login kedalam variabel $carts.
            $carts = Cart::where('user_id', $request->user()->id);

            // lakukan perulangan data $carts yang kita ubah menjadi variabel $cart.
            foreach($carts->get() as $cart){
                // masukan data baru transaction details dengan "transaction_id" sesuai dengan variabel $invoice.
                $invoice->details()->create([
                    'course_id' => $cart->course_id,
                    'price' => $cart->price
                ]);
            }

            // tampung array multidimensional kedalam variabel $payload yang nantinya akan kita kirimkan data tersebut ke payment gateway (midtrans).
            $payload = [
                'transaction_details' => [
                    'order_id' => $invoice->invoice,
                    'gross_amount' => $invoice->grand_total
                ],
                'customer_details' => [
                    'first_name' => $invoice->name,
                    'email' => $request->user()->email,
                ],
                'item_details' => $carts->get()->map(fn($cart) => [
                    'id' => $cart->id,
                    'price' => $cart->price,
                    'quantity' => 1,
                    'name' => Str::limit($cart->course->name, 40)
                ])
            ];

            // tampung data snap token midtrans yang terdapat data variabel $payload kedalam variabel $snapToken.
            $snapToken = Snap::getSnapToken($payload);

            // masukan data variabel $snapToken kedalam variabel $invoice->snap_token.
            $invoice->snap_token = $snapToken;

            // simpan data variabel $invoice.
            $invoice->save();

            // hapus data variabel $carts.
            $carts->delete();

            // tampung data user dengan "role" admin kedalam variabel $admin.
            $admin = User::role('admin')->get();

            // kirimkan notifikasi kedapa variabel $admin dengan membawa data variabel $invoice.
            Notification::send($admin, new NewTransaction($invoice));

            // isi data response['snapToken] dengan variabel $snapToken.
            return $this->response['snapToken'] = $snapToken;
        });

        // passing variabel $snapToken kedalam view.
        return view('landing.cart.checkout', compact('snapToken'));
    }
}
