<?php

namespace Tests\Feature;

use App\User;
use App\Models\Post;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test to make sure this page is login protected
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = factory(User::class)->create();
        $response = $this->get('/post');

        # Not Logged in, is accessible
        $response->assertStatus(200);

        # Logged in, also accessible
        $response = $this->actingAs($user)->get('/post');

        $response->assertStatus(200);
    }

    /**
     * Test to make sure that when we create an english post, the correct
     * language is being detected.
     *
     * @return void
     */
    public function testRegularEnglishPost()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/post', [
            'tree_location' => 'REED',
            'tree_id' => '54',
            'treestory' => 'Here is my tree story!'
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('danger');
        $response->assertRedirect('/post');

        $post = Post::first();
        $this->assertEquals('Reed', $post->tree_location);
        $this->assertEquals('54', $post->tree_id);
        $this->assertEquals('Here is my tree story!', $post->content);
        $this->assertEquals('en', $post->language);
    }

    /**
     * Test to make sure that when we create a spanish post, the correct
     * language is being detected.
     *
     * @return void
     */
    public function testRegularSpanishPost()
    {
        $user = factory(User::class)->create();
        $story_text = 'prácticas para proteger a los consumidores.';

        $response = $this->actingAs($user)->post('/post', [
            'tree_location' => 'REED',
            'tree_id' => '54',
            'treestory' => $story_text
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('danger');
        $response->assertRedirect('/post');

        $post = Post::first();
        $this->assertEquals('Reed', $post->tree_location);
        $this->assertEquals('54', $post->tree_id);
        $this->assertEquals($story_text, $post->content);
        $this->assertEquals('es', $post->language);
    }
}
