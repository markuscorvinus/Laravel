<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    
    public function create()
    {
        return view('authors.create');
    }
    public function store(Request $request)
    {   
        $author = Author::create($this->validateRequest());
        //return redirect($book->path());
    }

   /*  public function update(Book $book)
    {
        $book->update($this->validateRequest());
        
        //return redirect('/books/' . $book->id);
        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }
    */

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'dob' => 'required',
        ]);
    }
}
