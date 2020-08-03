<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuninate\Support\Facades\DB;
use App\Profile;
use App\user;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $profile = DB::table('users')
                    ->join('profiles','users.id','=','profiles.user_id');
        return view('home');
    }
}
