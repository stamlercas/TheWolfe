<?php

namespace App\Lib;

use Illuminate\Support\Facades\Storage;

class FileName {
    public $name, $filename, $dir, $file;
    
    function __construct($file, $dir)
    {
        $this->file = $file;
        $this->dir = $dir;
        $this->name = $this->generateName($file);
        $this->filename = $this->dir . '/' . $this->name;
        
        $this->generateFileName();
    }
    
    public function generateFileName()
    {
        
        //loops through until image has a unique name, as to not overwrite any other images
        $name_exists_flag = true;
        while ($name_exists_flag)
        {
            if (Storage::disk('local')->has($this->filename))
            {
                $name = $this->generateName($file);
                $this->filename = $this->dir . '/' . $this->name;
            }
            else
            {
                $name_exists_flag = false;
            }
        }
    }
    
    private function generateName($file)
    {
        return rand(11111, 99999) . '.' . $this->file->getClientOriginalExtension();
    }
}