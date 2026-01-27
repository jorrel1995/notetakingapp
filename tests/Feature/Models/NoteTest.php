<?php

namespace Tests\Feature\Models;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    public function test_can_get_all_notes(): void
    {
        Note::factory()->count(3)->create();

        $response = $this->get('/notes');

        $response->assertStatus(200);
    }

    public function test_can_create_note(): void
    {
        $response = $this->post('/notes', [
            'title' => 'Test Note',
            'content' => 'This is a test note.',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('notes', [
            'title' => 'Test Note',
        ]);
    }

    public function test_can_get_single_note(): void
    {
        $note = Note::factory()->create();

        $response = $this->get('/notes/'.$note->id);

        $response->assertStatus(200);
    }

    public function test_can_edit_note(): void
    {
        $note = Note::factory()->create();

        $response = $this->get('/notes/'.$note->id.'/edit');

        $response->assertStatus(200);
    }

    public function test_can_update_note(): void
    {
        $note = Note::factory()->create();

        $response = $this->put('/notes/'.$note->id, [
            'title' => 'Updated Note',
            'content' => 'This is an updated note.',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Updated Note',
        ]);
    }

    public function test_can_delete_note(): void
    {
        $note = Note::factory()->create();

        $response = $this->delete('/notes/'.$note->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }
}
