<?php

namespace Tests\Feature;

use App\Author;
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
        $response = $this->post(route('book.store'), $this->data());
        
        $book = Book::first();

        //$response->assertOk();
        //$response->assertStatus(201);
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test **/
    public function a_title_is_required()
    {   
        //$this->withoutExceptionHandling();

        $response = $this->post(route('book.store'),array_merge($this->data(),['title' => '']));
        
        

        $response->assertSessionHasErrors('title');
        //$response->assertStatus(201);
        $this->assertCount(0, Book::all());
    }

    /** @test **/
    public function the_author_is_required()
    {   
        $response = $this->post(route('book.store'),array_merge($this->data(),['author_id' => '']));
        
        $response->assertSessionHasErrors('author_id');
        //$response->assertStatus(201);
        $this->assertCount(0, Book::all());
    }


    /** @test **/
    public function a_book_can_be_updated()
    {   
        //$this->withoutExceptionHandling();

        $this->post(route('book.store'), $this->data());

        $book = Book::first();
        
        $response = $this->patch($book->path(), [
            'title' => 'This a new Title',
            'author_id' => 'Boss Hugo',
        ]);
        

        $this->assertEquals('This a new Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }


    /** @test **/
    public function a_book_can_be_deleted()
    {   
        $this->withoutExceptionHandling();

        $this->post(route('book.store'), $this->data());

        $book = Book::first();
        
        $this->assertCount(1, Book::all());
        
        $response = $this->delete($book->path());
        
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

     /** @test **/
     public function a_new_author_is_automatically_added()
     { 
        $this->withoutExceptionHandling();

        $this->post(route('book.store'), $this->data());
        
        $book = Book::first();
        $author = Author::first();
        
        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
        
     }

     private function data()
     {
         return [
            'title' => 'This is a sample',
            'author_id' => 'Victor Hugo'
         ];
     }
}
