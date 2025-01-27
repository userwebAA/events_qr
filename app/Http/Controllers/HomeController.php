<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function index()
    {
        $qrcode = QrCode::size(300)->generate(route('quiz.show'));
        return view('home', compact('qrcode'));
    }
}
