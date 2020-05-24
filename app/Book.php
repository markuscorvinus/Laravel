<?php

namespace App;

use Exception;
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

    public function checkout(User $user)
    {
        $this->reservations()->create([
            'book_id' => $this->id,
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }

    public function checkin(User $user)
    {
        $reservation = $this->reservations()->where('user_id', $user->id)
            ->where('book_id', $this->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();
        
        if(is_null($reservation)){
            throw new Exception();
        }
        $reservation->update([
            'checked_in_at' => now()
        ]);    
    }
    

    public function path()
    {
        return '/books/' . $this->id . '-'. Str::slug($this->title);
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}   
