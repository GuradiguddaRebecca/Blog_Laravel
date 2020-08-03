<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class PostController extends Controller
{
    public function index(){
        $categories = Category::all();
        
        return view('posts.post',['categories' => $categories]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'designation'=>'required',
            'profile_pic'=>'required',

        ]);
    }
}
