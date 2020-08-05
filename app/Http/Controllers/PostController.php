<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use DB;
use App\Category;
use App\Post;
use App\like;
use App\dislike;
use Auth;
use App\Comment;

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
        $likePost = Post::find($post_id);
        $likeCtr = like::where(['post_id'=> $likePost->id])->count();
        $dislikeCtr = dislike::where(['post_id'=> $likePost->id])->count();
        $categories = Category::all();
        $comments = DB::table('users')
            ->join('comments', 'users.id', '=', 'comments.user_id')
            ->join('posts', 'comments.post_id', '=' , 'posts.id')
            ->select('users.name', 'comments.*')
            ->where(['posts.id'=>$post_id])
            ->get();
        
        return view('posts.view',['posts'=> $posts, 'categories' => $categories, 'likeCtr' => $likeCtr , 'dislikeCtr'=>$dislikeCtr, 'comments' => $comments]);
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

    public function like($id){
        $loggedin_user = Auth::user()->id;
        $like_user = like::where(['user_id' => $loggedin_user,'post_id' => $id])->first();
        if(empty($like_user->user_id)){
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;
            $like = new like;
            $like->user_id = $user_id;
            $like->email = $email;
            $like->post_id = $post_id;
            $like->save();
            return redirect("/view/{$id}");
        }
        else{
            return redirect("/view/{$id}");
        }
    }

    public function dislike($id){
        $loggedin_user = Auth::user()->id;
        $dislike_user = dislike::where(['user_id' => $loggedin_user,'post_id' => $id])->first();
        if(empty($dislike_user->user_id)){
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;
            $like = new dislike;
            $like->user_id = $user_id;
            $like->email = $email;
            $like->post_id = $post_id;
            $like->save();
            return redirect("/view/{$id}");
        }
        else{
            return redirect("/view/{$id}");
        }

    }

    public function comment(Request $request, $post_id){
        $this->validate($request, [
            'comment'=>'required',
           
        ]);

        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post_id;
        $comment->comment = $request->input('comment');
        $comment->save();
        return redirect("/view/{$post_id}")->with('response', 'Comment Added Successfully');
    }
}
