<?php

namespace Tests\Feature\Team;

use Tests\TestCase;
use App\Team;

class TeamControllerTest extends TestCase
{
    /** @test */
    public function test_can_get_teams_status_200()
    {
        factory(Team::class, 10)->create();
        $response = $this->get('/api/teams/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_create_an_team_status_201()
    {
        $data = [
      'title' => $this->faker->word,
    ];

        $this->post('/api/teams', $data)
      ->assertStatus(201);
    }

    /** @test */
    public function test_can_update_an_team_status_200()
    {
        $team = factory(Team::class)->create();
        $data = [
      'title' => $this->faker->word,
    ];

        $this->put('/api/teams/'.$team->id, $data)
      ->assertStatus(200);
    }

    /** @test */
    public function test_can_delete_an_team_status_204()
    {
        $team = factory(Team::class)->create();

        $this->delete('/api/teams/'.$team->id)
      ->assertStatus(204);
    }

    /** @test */
    public function test_cant_delete_an_team_status_204()
    {
        $this->delete('/api/teams/1')
      ->assertStatus(404);
    }
}
