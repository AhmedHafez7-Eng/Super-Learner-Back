<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Mail;
// use App\Mail\MailNotify;
use App\Mail\mailTrap;

class mailController extends Controller
{
    public function store(Request $request)
    {
        // $order = Order::findOrFail($request->order_id);

        Mail::to('daliamahmoud313@gmail.com')->send(new mailTrap());
    }
}