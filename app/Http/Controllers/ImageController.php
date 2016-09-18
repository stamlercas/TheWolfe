<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller {
    
    private function getImage($filename, $directory)
    {
        $file = Storage::disk('local')->get($directory . '/' . $filename);
        return Response($file, 200)->header('Content-Type', 'image/' . File::extension($filename));
    }
    
    public function getPostImage($filename)
    {
        return $this->getImage($filename, 'posts');
        
    }
    
    public function getUserImage($filename)
    {
        return $this->getImage($filename, 'users');
    }
    
}
