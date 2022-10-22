<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //Show index page
    public function index()
    {
        return view('admin.index');
    }
    //Show manage user list
    public function manageUser()
    {
        return view('users.manage', [
            'users' => User::latest('id')
                        -> get()
        ]);
    }
}
