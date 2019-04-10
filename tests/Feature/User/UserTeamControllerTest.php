<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Team;
use App\User;

class UserTeamControllerTest extends TestCase
{
    /** @test */
    public function test_can_get_user_teams_status_200()
    {
        $user = factory(User::class)->create();
        $teams = factory(Team::class, 10)->create();
        foreach ($teams as $team) {
            $team->members()->attach($user);
        }
        $response = $this->get('/api/users/'.$user->id.'/teams');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_add_user_to_team_status_200()
    {
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();
        $response = $this->put('/api/users/'.$user->id.'/teams/'.$team->id);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_update_user_teams_status_200()
    {
        $user = factory(User::class)->create();
        $teams = factory(Team::class, 10)->create();
        $data = ['teams_ids' => $teams->pluck('id')->toArray()];
        $response = $this->put('/api/users/'.$user->id.'/teams', $data);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
