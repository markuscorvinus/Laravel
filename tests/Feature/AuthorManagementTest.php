<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function author_can_be_added()
    {   
        $this->withoutExceptionHandling();

        $response = $this->post(route('author.store'), $this->data());
        
        $author = Author::all();            
        
        $response->assertOk();
        //$response->assertStatus(201);
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1998/15/05', $author->first()->dob->format('Y/d/m'));
        //$response->assertRedirect($book->path());
    }

    /** @test **/
    public function a_name_is_required()
    {
        $response = $this->post(route('author.store'), array_merge($this->data(), ['name' => '']));
        
        $response->assertSessionHasErrors('name');
    }


    /** @test **/
    public function a_dob_is_required()
    {
        $response = $this->post(route('author.store'), array_merge($this->data(), ['dob' => '']));
        
        $response->assertSessionHasErrors('dob');
    }


    private function data()
    {
        return [
            'name' => 'Sigmund Freud',
            'dob' => '05/15/1998'
        ];
    }
}   
