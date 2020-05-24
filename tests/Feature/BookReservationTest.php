<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function books_can_be_added()
    {   
        $this->withoutExceptionHandling();

        $response = $this->post(route('book.store'),[
            'title' => 'The Old World',
            'author' => 'Sigmund Freud'
        ]);
        
        

        $response->assertOk();
        //$response->assertStatus(201);
        $this->assertCount(1, Book::all());
    }

    /** @test **/
    public function a_title_is_required()
    {   
        //$this->withoutExceptionHandling();

        $response = $this->post(route('book.store'),[
            'title' => '',
            'author' => 'Sigmund Freud'
        ]);
        
        

        $response->assertSessionHasErrors('title');
        //$response->assertStatus(201);
        $this->assertCount(0, Book::all());
    }

    /** @test **/
    public function the_author_is_required()
    {   
        $response = $this->post(route('book.store'),[
            'title' => 'This is a sample',
            'author' => ''
        ]);
        
        $response->assertSessionHasErrors('author');
        //$response->assertStatus(201);
        $this->assertCount(0, Book::all());
    }


    /** @test **/
    public function a_book_can_be_updated()
    {   
        $this->withoutExceptionHandling();

        $this->post(route('book.store'),[
            'title' => 'This is a sample',
            'author' => 'Victor Hugo'
        ]);

        $book = Book::first();
        
        $response = $this->patch('/books/'. $book->id, [
            'title' => 'This a new Title',
            'author' => 'Boss Hugo',
        ]);
        

        $this->assertEquals('This a new Title', Book::first()->title);
        $this->assertEquals('Boss Hugo', Book::first()->author);
    }
}
