<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SASTController extends Controller
{
    //Home page
    public function index()
    {
        return view('sast.index');
    }
}
