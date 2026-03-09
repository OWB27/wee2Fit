<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MethodologyController extends Controller
{
    public function index()
    {
        return view('methodology');
    }
}