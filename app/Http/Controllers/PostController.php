<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use DB;
use App\Category;
use App\Post;
use Auth;

class PostController extends Controller
{
    public function index(){
        $categories = Category::all();

        return view('posts.post',['categories' => $categories]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'post_title'=>'required',
            'post_body' =>'required',
            'category_id'=>'required',
            'post_image'=>'required'
           
        ]);
        $posts = new Post;
        $posts->post_title = $request->input('post_title');
        $posts->user_id = Auth::user()->id;
        $posts->post_body = $request->input('post_body');
        $posts->category_id = $request->input('category_id');

        if($request->hasFile('post_image')){
            $file = $request->file('post_image');
            $file->move(public_path(). '/posts/', $file->
                getClientOriginalName());
            $url = URL::to("/") .'/posts/'. $file->
                getClientOriginalName(); 
                        
        }
        $posts->post_image = $url;
        $posts->save();
        return redirect('/home')->with('response','Post Published Successfully');
    }

    public function show($post_id){
        $posts = Post::where('id', '=', $post_id)->get();
        $categories = Category::all();
      
        return view('posts.view',['posts'=> $posts, 'categories' => $categories]);
    }

    public function edit($post_id){
        $categories = Category::all();
        $posts = Post::find($post_id);
        $category = Category::find($posts->category_id);
        return view('posts.edit',['categories' => $categories , 'posts' => $posts, 'category'=> $category ]);

    }

    public function editPost(Request $request, $post_id){
        $this->validate($request, [
            'post_title'=>'required',
            'post_body' =>'required',
            'category_id'=>'required',
            'post_image'=>'required'
           
        ]);
        $posts = new Post;
        $posts->post_title = $request->input('post_title');
        $posts->user_id = Auth::user()->id;
        $posts->post_body = $request->input('post_body');
        $posts->category_id = $request->input('category_id');

        if($request->hasFile('post_image')){
            $file = $request->file('post_image');
            $file->move(public_path(). '/posts/', $file->
                getClientOriginalName());
            $url = URL::to("/") .'/posts/'. $file->
                getClientOriginalName(); 
                        
        }
        $posts->post_image = $url;
        $data = array(
            'post_title'=> $posts->post_title,
            'user_id'=> $posts->user_id,
            'post_body'=> $posts->post_body,
            'category_id'=> $posts->category_id,
            'post_image'=> $posts->post_image
        );
        Post::where('id',$post_id)
        ->update($data);
        $posts->update();
        return redirect('/home')->with('response','Post Updated Successfully');
        
    }

    public function delete($post_id){
        Post::where('id',$post_id)->delete();
        return redirect('/home')->with('response','Deleted Successfully');
    }

    public function category($cat_id){
        $categories = Category::all();
        $posts = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.*', 'categories.*')
            ->where(['categories.id'=>$cat_id])
            ->get();
           
        return view('categories.categoriesposts',['categories' => $categories, 'posts' =>$posts]);
    }
}
