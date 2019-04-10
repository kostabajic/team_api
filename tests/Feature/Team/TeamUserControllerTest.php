<?php

namespace Tests\Feature\Team;

use Tests\TestCase;
use App\User;
use App\Team;

class TeamUserControllerTest extends TestCase
{
    /** @test */
    public function test_can_add_owner_to_team_status_200()
    {
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();
        $response = $this->put('/api/teams/'.$team->id.'/owners/'.$user->id);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_get_team_to_owner_status_200()
    {
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();
        $team->owner()->associate($user);
        $team->save();
        $response = $this->get('/api/teams/'.$team->id.'/owners');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_delete_owner_status_204()
    {
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();
        $team->owner()->associate($user);
        $team->save();
        $response = $this->delete('/api/teams/'.$team->id.'/owners');
        $this->assertEquals(204, $response->getStatusCode());
    }
}
