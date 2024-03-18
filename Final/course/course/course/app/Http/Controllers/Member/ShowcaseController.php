<?php

namespace App\Http\Controllers\Member;

use App\Models\Showcase;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShowcaseRequest;
use Illuminate\Support\Facades\Storage;

class ShowcaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
            tampung seluruh data showcase yang dimiliki user yang sedang login kedalam variabel $showcases,
            kemudian kita pecah data showcase yang kita tampilkan hanya 10 per halaman
            dengan urutan terbaru.
        */
        $showcases = Showcase::where('user_id', $request->user()->id)->latest()->paginate(10);

        // passing variabel $showcases kedalam view.
        return view('member.showcase.index', compact('showcases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // tampung user yang sedang login kedalam variabel $user.
        $user = Auth::user();

        /*
            tampung data transaction detail kedalam variabel $courses, kemudian kita memanggil relasi menggunakan with,
            selanjutnya kita melakukan sebuah query untuk mengambil data transaction yang memiliki status success dan seusai dengan user yang sedang login.
        */
        $courses = TransactionDetail::with('transaction', 'course.reviews')
                ->whereHas('transaction', function($query) use($user){
                    $query->where('user_id', $user->id)->where('status', 'success');
                })->get();

        // passing variabel $courses kedalam view.
        return view('member.showcase.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShowcaseRequest $request)
    {
        // tampung request file cover kedalam variable $cover.
        $cover = $request->file('cover');
        // request yang telah kita tampung kedalam variabel, kita masukan kedalam folder public/showcases.
        $cover->storeAs('public/showcases', $cover->hashName());

        // masukan data baru showcase dengan "user_id" sesuai dengan user yang sedang login
        $request->user()->showcases()->create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $cover->hashName()
        ]);

        // kembali kehalaman member/showcase/index dengan membawa toastr.
        return redirect(route('member.showcase.index'))->with('toasts_success', 'Showcase Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Showcase $showcase)
    {
        // tampung data user yang sedang login kedalam variabel $user.
        $user = Auth::user();

        /*
            tampung data transaction detail kedalam variabel $courses, kemudian kita memanggil relasi menggunakan with,
            selanjutnya kita melakukan sebuah query untuk mengambil data transaction yang memiliki status success dan seusai dengan user yang sedang login.
        */
        $courses = TransactionDetail::with('transaction', 'course.reviews')
                ->whereHas('transaction', function($query) use($user){
                    $query->where('user_id', $user->id)->where('status', 'success');
                })->get();

        // passing variabel $showcase dan $courses kedalam view.
        return view('member.showcase.edit', compact('showcase', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShowcaseRequest $request, Showcase $showcase)
    {
        // update data showcase berdasrkan showcase id dan "user_id" sesuai dengan user yang sedang login
        $showcase->update([
            'user_id' => $request->user()->id,
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        // cek apakah user mengirimkan request file cover
        if($request->file('cover')){
            //hapus cover showcase yang sebelumnya.
            Storage::disk('local')->delete('public/showcases/'.basename($showcase->cover));
            // tampung request file cover kedalam variabel $cover
            $cover = $request->file('cover');
            // request yang telah kita tampung kedalam variabel, kita masukan kedalam folder public/showcases.
            $cover->storeAs('public/showcases/', $cover->hashName());
            // update data showcase image berdasarkan id.
            $showcase->update([
                'cover' => $cover->hashName(),
            ]);
        }

        // kembali kehalaman member/showcase/index dengan membawa toastr.
        return redirect(route('member.showcase.index'))->with('toast_success', 'Showcase Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Showcase $showcase)
    {
        // hapus cover showcase berdasarkan id.
        Storage::disk('local')->delete('public/showcases/'.basename($showcase->cover));

        // hapus data category berdasarkan id.
        $showcase->delete();

        // kembali kehalaman sebelumnya dengan membawa toastr.
        return back()->with('toast_success', 'Showcase Deleted');
    }
}
