<?php

namespace Tests\Feature\User;

use Tests\TestCase;

class UserTeamControllerTest extends TestCase
{
    /** @test */
    public function test_can_get_user_teams_status_200()
    {
        list($user, $teams) = $this->createUserTeams();
        foreach ($teams as $team) {
            $team->members()->attach($user);
        }
        $response = $this->get('/api/users/'.$user->id.'/teams');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_add_user_to_team_status_200()
    {
        list($user, $team) = $this->createUserTeam();
        $response = $this->put('/api/users/'.$user->id.'/teams/'.$team->id);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_update_user_teams_status_200()
    {
        list($user, $teams) = $this->createUserTeams();
        $data = ['teams_ids' => $teams->pluck('id')->toArray()];
        $response = $this->put('/api/users/'.$user->id.'/teams', $data);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_get_user_teams()
    {
        list($user, $teams) = $this->createUserTeams();
        foreach ($teams as $team) {
            $team->members()->attach($user);
        }
        $response = $this->get('/api/users/'.$user->id.'/teams');
        $response->assertJsonStructure([
             'data' => [
                 ['member_id'],
                 ['team_id'],
                 ['owner_name'],
                 ['team_title'],
                 ['role'],
             ],
         ]);
        $this->assertCount(10, $response->json('data'));
    }

    /** @test */
    public function test_can_add_user_to_team()
    {
        list($user, $team) = $this->createUserTeam();
        $response = $this->put('/api/users/'.$user->id.'/teams/'.$team->id);
        $this->assertCount(1, $response->json('data'));
    }

    /** @test */
    public function test_can_update_user_teams()
    {
        list($user, $teams) = $this->createUserTeams();
        $data = ['teams_ids' => $teams->pluck('id')->toArray()];
        $response = $this->put('/api/users/'.$user->id.'/teams', $data);
        $response->assertJsonStructure([
             'data' => [
                 ['member_id'],
                 ['team_id'],
                 ['owner_name'],
                 ['team_title'],
                 ['role'],
             ],
         ]);
        $this->assertCount(count($teams), $response->json('data'));
    }
}
