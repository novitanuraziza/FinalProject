<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationDatabaseController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function readNotification($id)
    {
        // ambil data notifikasi dari user yang sedang login kemudian "mark as read" yang dimana "id"nya sama dengan variabel $id.
        Auth::user()->notifications->where('id', $id)->markAsRead();

        // kembali kehalaman sebelumnya.
        return back();
    }

    public function readAllNotification()
    {
        // ambil seluruh data notifikasi yang belum dibaca kemudian "mark as read"
        Auth::user()->unreadNotifications->markAsRead();

        // kembali kehalaman sebelumnya.
        return back();
    }
}
