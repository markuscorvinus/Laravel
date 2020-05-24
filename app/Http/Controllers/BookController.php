<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {   
        $book = Book::create($this->validateRequest());

        return redirect($book->path());
    }

    public function update(Book $book)
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


    private function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author_id' => 'required',
        ]);
    }
}
