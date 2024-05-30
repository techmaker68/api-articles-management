<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_article()
    {
        $response = $this->postJson('/api/articles', [
            'title' => 'Test Article',
            'body' => 'This is a test article.',
            'author' => 'Author',
            'publication_date' => now(),
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'id', 'title', 'body', 'author', 'publication_date', 'created_at', 'updated_at',
        ]);
    }

    public function test_can_list_articles()
    {
        Article::factory()->count(3)->create();

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_update_article()
    {
        $article = Article::factory()->create();

        $response = $this->putJson("/api/articles/{$article->id}", [
            'title' => 'Updated Title',
            'body' => 'Updated body',
            'author' => 'Updated Author',
            'publication_date' => now(),
        ]);

        $response->assertStatus(200)->assertJson([
            'title' => 'Updated Title',
            'body' => 'Updated body',
        ]);
    }

    public function test_can_delete_article()
    {
        $article = Article::factory()->create();

        $response = $this->deleteJson("/api/articles/{$article->id}");

        $response->assertStatus(204);
    }
}
