<?php

namespace App\Http\Controllers\Member;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Course $course)
    {
        /*
            masukan data baru review dengan "course_id" sesuai dengan variabel $course, karena disini kita menggunakan
            updateOrCreate maka jika user yang sedang login pernah memberikan review maka data hanya akan diupdate jika belum
            maka akan memasukan data baru.
        */
        $course->reviews()->UpdateOrcreate([
            'user_id' => $request->user()->id,
        ],[
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // kembali kehalaman sebelumnya dengan membawa toastr.
        return back()->with('toast_success', 'Review Created');
    }
}
