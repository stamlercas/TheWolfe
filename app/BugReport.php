<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    public function user()
    {
        $this->belongsTo('App\User');
    }
}
