<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    private $token;

    public function setUp(): void
    {
        parent::setUp();

        // Ensure a fresh state before each test
        $this->artisan('migrate:fresh');

        // Create a unique user and get the authentication token
        $user = User::factory()->create([
            'email' => 'test' . time() . '@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->token = $response->json('token');

        $this->withoutExceptionHandling();
    }

    private function withAuthHeaders($headers = [])
    {
        return array_merge($headers, [
            'Authorization' => 'Bearer ' . $this->token,
        ]);
    }

    /** @test */
    public function it_can_get_all_articles()
    {
        Article::factory()->count(3)->create();

        $response = $this->getJson('/api/article', $this->withAuthHeaders());

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_get_a_single_article()
    {
        $article = Article::factory()->create();

        $response = $this->getJson("/api/article/{$article->id}", $this->withAuthHeaders());

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $article->id,
                         'title' => $article->title,
                         'body' => $article->body,
                         'author' => $article->author,
                         'publication_date' => $article->publication_date,
                     ]
                 ]);
    }

    /** @test */
    public function it_can_create_an_article()
    {
        $articleData = Article::factory()->make()->toArray();

        $response = $this->postJson('/api/article', $articleData, $this->withAuthHeaders());

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'title' => $articleData['title'],
                         'body' => $articleData['body'],
                         'author' => $articleData['author'],
                         'publication_date' => $articleData['publication_date'],
                     ]
                 ]);

        $this->assertDatabaseHas('articles', $articleData);
    }

    /** @test */
    public function it_can_update_an_article()
    {
        $article = Article::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'body' => 'Updated body',
            'author' => 'Updated Author',
            'publication_date' => now()->format('Y-m-d'),
        ];

        $response = $this->putJson("/api/article/{$article->id}", $updatedData, $this->withAuthHeaders());

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $article->id,
                         'title' => 'Updated Title',
                         'body' => 'Updated body',
                         'author' => 'Updated Author',
                         'publication_date' => now(),
                     ]
                 ]);

        $this->assertDatabaseHas('articles', $updatedData);
    }

    /** @test */
    public function it_can_delete_an_article()
    {
        $article = Article::factory()->create();

        $response = $this->deleteJson("/api/article/{$article->id}", [], $this->withAuthHeaders());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
