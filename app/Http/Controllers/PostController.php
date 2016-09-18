<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Lib\FileName;

class PostController extends Controller 
{
    public function getDashboard()
    {
        $posts = Post::orderBy('created_at', 'desc')->get(); //fetch all posts
        return view('dashboard', ['posts' => $posts]);
    }
    
    public function postCreatePost(Request $request)
    {
        //validation
        $this->validate($request, [
            'body' => 'required|max:140',
            'image_url' => 'required|min:6'
        ],
        [
            'image_url.required' => 'You must upload an image and wait for that image to finish uploading before posting.'
        ]);
        $post = new Post();
        $post->body = $request['body'];
        $post->image_url = $request['image_url'];
        
        $message = 'There was an error.';
        if ($request->user()->posts()->save($post)) //save post in relation to user
        {
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);   //if passing only one variable, you don't
                                                                                //have to use an array
    }
    
    public function getDeletePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        if (Auth::user() != $post->user)    //making sure users don't delete other user's posts
        {
            return redirect()->back();
        }
        $post->delete();
        
        return redirect()->route('dashboard')->with(['message' => 'Post successfully deleted.']);
    }
    
    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:140'
            //'image_url' => 'required|min:6'
        ]);
        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user)    //making sure users don't delete other user's posts
        {
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }
    
    //stores image and returns the filename generated
    public function postStorePostImage(Storage $storage, Request $request)
    {
        $file = $request->file('file');
        $dir = 'posts';
        $file_name = new FileName($file, $dir);
        
        if ($file) {
            Storage::disk('local')->put($file_name->filename, File::get($file));
            return response()->json(['filename' => $file_name->name], 200);
        }
    }
    
    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $type = $request['type'];
        
        $update = false;    //keep track
        $post =  Post::find($post_id);
        if (!$post)
        {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();    //should only be one
                                                                        //check if user already liked post
        if ($like)
        {
            $update = true;
            if ($like->type == $type) //post is already liked, so undo like
            {
                $like->delete();
                return null;
            }
        }
        else
        {
            $like = new Like();
        }
        $like->type = $type;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update)    //if already in db, just update it
        {
            $like->update();
        }
        else            //not updated, so save new row
        {
            $like->save();
        }
        return null;
    }
}