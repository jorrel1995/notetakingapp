<?php

namespace Tests\Feature\Models;

use Tests\TestCase;

class NoteTest extends TestCase
{
    public function test_can_get_all_notes(): void
    {
        $response = $this->get('/notes');

        $response->assertStatus(200);
    }

    public function test_can_create_note(): void
    {
        $response = $this->post('/notes', [
            'title' => 'Test Note',
            'content' => 'This is a test note.',
        ]);

        $response->assertStatus(201);
    }

    public function test_can_get_single_note(): void
    {
        $response = $this->get('/notes/1');

        $response->assertStatus(200);
    }

    public function test_can_update_note(): void
    {
        $response = $this->put('/notes/1', [
            'title' => 'Updated Note',
            'content' => 'This is an updated note.',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_note(): void
    {
        $response = $this->delete('/notes/1');

        $response->assertStatus(200);
    }
}
