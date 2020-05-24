<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Author extends Model
{
    protected $fillable = ['name','dob'];

    protected $dates = ['dob'];

    //protected $dateFormat = 'U';

    public function getDobAttribute($dob)
    {
        return $this->attributes['dob'] = Carbon::parse($dob);
    }
}
