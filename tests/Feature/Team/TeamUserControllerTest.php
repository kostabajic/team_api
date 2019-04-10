<?php

namespace Tests\Feature\Team;

use Tests\TestCase;

class TeamUserControllerTest extends TestCase
{
    /** @test */
    public function test_can_add_owner_to_team_status_200()
    {
        list($user, $team) = $this->createUserTeam();
        $response = $this->put('/api/teams/'.$team->id.'/owners/'.$user->id);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_get_team_to_owner_status_200()
    {
        list($user, $team) = $this->createUserTeam();
        $team->owner()->associate($user);
        $team->save();
        $response = $this->get('/api/teams/'.$team->id.'/owners');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_delete_owner_status_204()
    {
        list($user, $team) = $this->createUserTeam();
        $team->owner()->associate($user);
        $team->save();
        $response = $this->delete('/api/teams/'.$team->id.'/owners');
        $this->assertEquals(204, $response->getStatusCode());
    }

    /** @test */
    public function test_can_add_owner_to_team()
    {
        list($user, $team) = $this->createUserTeam();
        $response = $this->put('/api/teams/'.$team->id.'/owners/'.$user->id);
        $content = $response->json('data');
        $this->assertEquals($user->id, $content['user_id']);
    }

    /** @test */
    public function test_can_get_team_to_owner()
    {
        list($user, $team) = $this->createUserTeam();
        $team->owner()->associate($user);
        $team->save();
        $response = $this->get('/api/teams/'.$team->id.'/owners');
        $content = $response->json('data');
        $this->assertEquals($user->id, $content['user_id']);
    }

    /** @test */
    public function test_can_get_team_users()
    {
        list($users, $team) = $this->createUsersTeam();
        foreach ($users as $user) {
            $team->members()->attach($user);
        }
        $response = $this->get('/api/teams/'.$team->id.'/users');
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertJsonStructure([
             'data' => [
                 ['member_id'],
                 ['user_id'],
                 ['member_name'],
                 ['role_id'],
                 ['role'],
             ],
         ]);
        $this->assertCount(count($users), $response->json('data'));
    }

    /** @test */
    public function test_can_add_team_to_user()
    {
        list($user, $team) = $this->createUserTeam();
        $response = $this->put('/api/teams/'.$team->id.'/users/'.$user->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(1, $response->json('data'));
    }

    /** @test */
    public function test_can_update_team_users()
    {
        list($users, $team) = $this->createUsersTeam();
        $data = ['member_user_ids' => $users->pluck('id')->toArray()];
        $response = $this->put('/api/teams/'.$team->id.'/users', $data);
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertJsonStructure([
             'data' => [
                 ['member_id'],
                 ['user_id'],
                 ['member_name'],
                 ['role_id'],
                 ['role'],
             ],
         ]);
        $this->assertCount(count($users), $response->json('data'));
    }
}
