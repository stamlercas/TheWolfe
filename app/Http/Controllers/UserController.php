<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Lib\FileName;

class UserController extends Controller {
    
    public function postSignUp(Request $request)
    {
        //validates form on the backend, pretty cool
        //will output an array of lists that is accessible from the view by using $errors->all()
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'username' => 'required|min:4|max:32|unique:users',
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'password' => 'required|min:4'
        ]);
        
        $email = $request['email'];
        $username = $request['username'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $password = bcrypt($request['password']);   //use laravel's encryption function
        
        $user = new User();
        $user->email = $email;
        $user->username= $username;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->password = $password;
        
        $user->save();
        
        Auth::login($user);
        
        return redirect()->route('dashboard');
    }
    
    public function postSignIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        
        //if it is successful, then return to dashboard
        //if it fails, redirect back
        if (Auth::attempt( ['email' => $request['email'], 'password' => $request['password']] ))
        {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withErrors( ['error' => 'The email and password do not match.'] );
    }
    
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    
    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }
    
    public function postSaveAccount(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120'
            //,'file' => 'mimes:jpeg,jpg,png,gif'
        ]);
        
        $user = Auth::user();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        
        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $file_name = new FileName($file, 'users');
            $user->image_url = $file_name->name;
            
            /*
            $filename = 'users/' . $request['first_name'] . '-' . $user->id . '.' . $file->getClientOriginalExtension()
            */
            if ($file) {
                Storage::disk('local')->put($file_name->filename, File::get($file));
            }
        }
        
        $user->update();
        
        return redirect()->route('user', ['username' => $user->username]);
    }
    
    public function getUser(Request $request, $username)
    {
        $user = User::where('username', $username)->first();
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        $postsCount = Post::where('user_id', $user->id )->count();
        
        if ($request->ajax())
        {
            return [
                'posts' => view('includes.post-feed')->with(compact('user', 'posts'))->render(),
                'next_page' => $posts->nextPageUrl()
            ];
        }
        
        return view('user', ['user' => $user, 'posts' => $posts, 'postsCount' => $postsCount]);
    }
}

