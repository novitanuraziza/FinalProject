<?php

namespace App\Http\Controllers\Landing;

use App\Models\Video;
use App\Models\Course;
use App\Models\Review;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        /*
            tampung semua data course kedalam variabel $courses, kemudian kita memanggil relasi menggunakan withcount,
            selanjutnya pada saat melakukan pemanggilan relasi details yang kita ubah namanya menjadi enrolled, disini kita melakukan sebuah query untuk mengambil data transaksi yang memiliki status "success", disini kita juga menambahkan method search yang kita dapatkan dari sebuah trait hasScope, dan juga kita urutkan datanya dari yang paling baru.
        */
        $courses = Course::withCount(['videos', 'reviews', 'details as enrolled' => function($query){
            $query->whereHas('transaction', function($query){
                $query->where('status', 'success');
            });
        }])->search('name')->latest()->get();

        // passing variabel $courses kedalam view.
        return view('landing.course.index', compact('courses'));
    }

    public function show(Course $course)
    {
        // tampung seluruh data video dengan "course_id" sesuai dengan variabel $course kedalam variabel $videos.
        $videos = Video::whereBelongsTo($course)->get();

        /*
            tampung jumlah data transaction yang memiliki status "success" kedalam variabel $enrolled, kemudian kita memanggil relasi menggunakan with, selanjutnya pada saat melakukan pemanggilan relasi details, kita melakukan sebuah query untuk mengambil data transaction detail dengan "course_id" sesuai dengan variabel $course->id.
        */
        $enrolled = Transaction::with('details.course')
            ->where('status', 'success')
            ->whereHas('details', function($query) use($course){
                $query->where('course_id', $course->id);
            })->count();

        /*
            tampung data transaction yang memiliki status "success" dan "user_id" sesuai dengan user yang sedang login kedalam variabel $alreadyBought, kemudian kita memanggil relasi menggunakan with, selanjutnya pada saat melakukan pemanggilan relasi details, kita melakukan sebuah query untuk mengambil data transaction detail dengan "course_id" sesuai dengan variabel $course->id.
        */
        if(Auth::user()){
            $alreadyBought = Transaction::with('details.course')
                ->where('status', 'success')
                ->where('user_id', Auth::id())
                ->whereHas('details', function($query) use($course){
                    $query->where('course_id', $course->id);
                })->first();
        }else{
            $alreadyBought = [];
        }

        // passing variabel $course, $videos, $enrolled, dan $alreadyBought kedalam view.
        return view('landing.course.show', compact('course', 'videos', 'enrolled', 'alreadyBought'));
    }

    public function video(Course $course, $episode)
    {
        // tampung data user yang sedang login kedalam variable $user.
        $user = Auth::user();

        // tampung data video dengan "course_id" dan "episode" sesuai dengan variabel $course dan $episode kedalam variabel $video.
        $video = Video::whereBelongsTo($course)->where('episode', $episode)->first();

        /*
            tampung data transaction yang memiliki status "success" dan "user_id" sesuai dengan user yang sedang login kedalam variabel $transaction, kemudian kita memanggil relasi menggunakan with, selanjutnya pada saat melakukan pemanggilan relasi details, kita melakukan sebuah query untuk mengambil data transaction detail dengan "course_id" sesuai dengan variabel $course->id.
        */
        if($user){
            $transaction = Transaction::with('user', 'details.course')
                ->where('user_id', $user->id)
                ->where('status', 'success')
                ->whereHas('details', function($query) use($course){
                    $query->where('course_id', $course->id);
                })->get();
        }else{
            $transaction = [];
        }

        // tampung data review dengan "course_id" sesuai dengan variabel $course->id kedalam variabel $reviews.
        $reviews = Review::where('course_id', $course->id)->get();

        // tampung jumlah rata - rata dari "rating" data review dengan "course_id" sesuai dengan variabel $course->id kedalam variabel $avgRating.
        $avgRating = Review::where('course_id', $course->id)->avg('rating');

        // cek apakah variabel $transaction memiliki nilai atau tidak.
        if(count($transaction)){
            // tampung data variabel $transaction kedalam variabel $alreadyBought.
            $alreadyBought = $transaction;
        // jika variabel $transaction tidak memiliki nilai
        }else{
            // tampung empty string kedalam variabel $alreadyBought
            $alreadyBought = '';
        }

        // cek apakah data variabel $video dengan "intro" sama dengan 0 dan atau apakah data variabel $alreadyBounght memiliki nilai atau tidak
        if($alreadyBought || $video->intro == 0){
            // tampung seluruh data video dengan "course_id" sesuai dengan variabel $course kedalam variabel $videos, dan data yang ditampilkan diurutkan berdasarkan episode.
            $videos = Video::whereBelongsTo($course)->orderBy('episode')->get();
        // jila data variabel $video dengan "intro" sama dengan 1, dan atau data variabel $alreadyBought tidak memiliki nilai.
        }else{
            // kembali kehalaman sebelumnya dengan membawa toastr.
            return back()->with('toast_error', 'Episode ini hanya untuk member premium');
        }

        // passing variabel $course, $video, $videos, $alreadyBought, $reviews, dan $avgRating kedalam view.
        return view('landing.course.video', compact('course','video', 'videos', 'alreadyBought', 'reviews', 'avgRating'));
    }
}
