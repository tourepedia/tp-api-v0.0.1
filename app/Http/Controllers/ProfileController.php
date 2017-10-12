<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function __contruct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        return view("users.profile", ["user" => Auth::user()]);
    }
}
