<?php

namespace App\Http\Controllers\Landing;

use App\Models\Cart;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // tampung data cart dari user yang sedang login kedalam variabel $carts.
        $carts = $request->user()->carts()->get();

        // jumlahkan "price" dari variabel $carts kemudian tampung data tersebut kedalam variabel $total.
        $total = $carts->sum('price');

        // tampung data user yang sedang login kedalam variabel $user.
        $user = $request->user();

        // passing variabel $carts, $total, $user kedalam view.
        return view('landing.cart.index', compact('carts', 'total', 'user'));
    }

    public function store(Request $request, Course $course)
    {
        /*
            masukan data baru cart dengan "course_id" sesuai dengan variabel $course, karena disini kita menggunakan
            updateOrCreate maka jika user yang sedang login pernah memasukan course kedalam cart maka data hanya akan diupdate jika belum maka akan memasukan data baru.
        */
        $course->carts()->updateOrCreate([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
        ],[
            'user_id' => $request->user()->id,
            'price' => $course->price - ($course->price * $course->discount / 100),
        ]);

        // kembali kehalaman cart/index dengan membawa toastr.
        return redirect(route('cart.index'))->with('toast_success', 'Item berhasil ditambahkan ke cart');
    }

    public function delete(Cart $cart)
    {
        // hapus data cart berdasarkan id.
        $cart->delete();

        // kembali kehalaman sebelumnya dengan membawa toastr.
        return back()->with('toast_success', 'Item berhasil dihapus dari cart');
    }
}
