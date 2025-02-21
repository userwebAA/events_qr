<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('order')->get();
        return view('welcome', compact('questions'));
    }
}
