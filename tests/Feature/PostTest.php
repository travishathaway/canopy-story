<?php

namespace Tests\Feature;

use App\User;
use App\Models\Post;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

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

    /**
     * Create a spanish and english post and make sure that we only
     * get results back from post with just english or just spanish
     */
    public function testEnglishAndSpanishPostList()
    {
        $user = factory(User::class)->create();

        # Create the posts
        $story_text = 'prácticas para proteger a los consumidores.';
        $response = $this->actingAs($user)->post('/post', [
            'tree_location' => 'REED',
            'tree_id' => '54',
            'treestory' => $story_text
        ]);

        $story_text = 'Hey, this is a post in English';
        $response = $this->actingAs($user)->post('/post', [
            'tree_location' => 'REED',
            'tree_id' => '54',
            'treestory' => $story_text
        ]);

        # Mock a request object
        $request = new Request();
        $users = array();

        # List english
        $posts = Post::getPostList($request, $users, 'en')->get();

        # Make sure we just get the first english post back
        $this->assertEquals(1, count($posts));
        $this->assertEquals('en', $posts[0]->language);

        # List spanish
        $posts = Post::getPostList($request, $users, 'es')->get();

        # Make sure we just get the first spanish post back
        $this->assertEquals(1, count($posts));
        $this->assertEquals('es', $posts[0]->language);
    }

    /**
     * Test the scenario where tree id is zero
     */
    public function testWithTreeIdZero()
    {
        $user = factory(User::class)->create();

        # Create the posts
        $story_text = 'So, yeah, there really are tree ids that equal zero :/';
        $response = $this->actingAs($user)->post('/post', [
            'tree_location' => 'REED',
            'tree_id' => '0',
            'treestory' => $story_text
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('danger');
        $response->assertRedirect('/post');
    }
}
