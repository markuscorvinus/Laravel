<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $fillable = ['title','author_id'];

    

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author
        ]))->id;
        
    }
    

    public function path()
    {
        return '/books/' . $this->id . '-'. Str::slug($this->title);
    }
}   
