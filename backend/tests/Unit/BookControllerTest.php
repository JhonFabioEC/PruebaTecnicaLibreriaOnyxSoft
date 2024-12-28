<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/books');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function it_returns_404_if_no_books_are_found()
    {
        $response = $this->getJson('/api/v1/books');

        $response->assertStatus(404)
            ->assertJsonStructure(['books', 'message', 'status']);
    }

    #[Test]
    public function it_can_store_a_new_book()
    {
        $data = [
            "title" => "Cien años de soledad",
            "author" => "Gabriel García Márquez",
            "publication_year" => 1967,
            "genre" => "Literario del Drama"
        ];

        $response = $this->postJson('/api/v1/books', $data);

        $response->assertStatus(201)
            ->assertJsonPath('book.title', $data['title']);

        $this->assertDatabaseHas('book', $data);
    }

    #[Test]
    public function it_returns_validation_errors_when_storing_a_book()
    {
        $data = [
            'title' => '',
            'author' => '',
            'publication_year' => '',
            'genre' => ''
        ];

        $response = $this->postJson('/api/v1/books', $data);

        $response->assertStatus(400)
            ->assertJsonStructure(['message', 'errors', 'status']);
    }

    #[Test]
    public function it_can_show_a_specific_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonPath('book.title', $book->title);
    }

    #[Test]
    public function it_returns_404_when_book_not_found()
    {
        $response = $this->getJson('/api/v1/books/999');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Libro no encontrado'
            ]);
    }

    #[Test]
    public function it_can_update_a_book()
    {
        $book = Book::factory()->create();

        $data = [
            "title" => "Cien años solo",
            "author" => "Gabriel Enrique Márquez",
            "publication_year" => 2024,
            "genre" => "Terror"
        ];

        $response = $this->putJson("/api/v1/books/{$book->id}", $data);

        $response->assertStatus(200)
            ->assertJsonPath('book.title', $data['title']);

        $this->assertDatabaseHas('book', $data);
    }

    #[Test]
    public function it_returns_validation_errors_when_updating_a_book()
    {
        $book = Book::factory()->create();

        $data = [
            'title' => '',
            'author' => '',
            'publication_year' => '',
            'genre' => ''
        ];

        $response = $this->putJson("/api/v1/books/{$book->id}", $data);

        $response->assertStatus(400)
            ->assertJsonStructure(['message', 'errors', 'status']);
    }

    #[Test]
    public function it_can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Libro eliminado']);

        $this->assertDatabaseMissing('book', ['id' => $book->id]);
    }

    #[Test]
    public function it_returns_404_when_deleting_a_non_existing_book()
    {
        $response = $this->deleteJson('/api/v1/books/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Libro no encontrado']);
    }
}
