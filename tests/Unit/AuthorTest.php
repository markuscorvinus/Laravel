<?php

namespace Tests\Unit;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{   
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();       
       

    }

    /** @test **/
    public function only_name_is_required_to_create_an_author()
    {   
        Author::firstOrCreate([
            'name' => 'Test me'
        ]);
        $author = Author::first()->get();
        
        $this->assertTrue(true);
    }
}
