<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{   
    use RefreshDatabase;

    /** @test **/
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {   
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();

        $this->actingAs($user = factory(User::class)->create())
            ->post(route('checkout', $book->id));

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }


    /** @test **/
    public function only_signed_in_user_can_checkout_a_book()
    {
        $book = factory(Book::class)->create();

        $response = $this->post(route('checkout', $book->id));

        $response->assertRedirect('/login');
        $this->assertCount(0, Reservation::all());       
    }


    /** @test **/
    public function only_existing_books_can_be_checkedout()
    {
        //$this->withoutExceptionHandling();
        $response = $this->actingAs($user = factory(User::class)->create())
            ->post(route('checkout', 20));

        $response->assertStatus(404);
        $this->assertCount(0, Reservation::all());        
    }

    /** @test **/
    public function a_book_can_be_checked_in_by_a_sign_in_user()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('checkout', $book->id));

        $this->actingAs($user)
            ->post(route('checkin', $book->id));

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }


    /** @test **/
    public function only_signed_in_user_can_checkin_a_book()
    {
        $book = factory(Book::class)->create();

        $this->actingAs(factory(User::class)->create())
        ->post(route('checkout', $book->id));

        Auth::logout();

        $response = $this->post(route('checkin', $book->id));

        $response->assertRedirect('/login');
        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);       
    }


    /** @test **/
    public function a_404_is_thrown_if_book_is_not_checkout_first()
    {   
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post(route('checkin', $book->id));

        $response->assertStatus(404);
        $this->assertCount(0, Reservation::all());        
    }

    /** @test **/
    /* public function only_existing_books_can_be_checked_in()
    {
        //$this->withoutExceptionHandling();
        $response = $this->actingAs($user = factory(User::class)->create())
            ->post(route('checkout', 20));

        $response->assertStatus(404);
        $this->assertCount(0, Reservation::all());        
    } */
}
