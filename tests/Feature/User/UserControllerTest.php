<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\User;

class UserControllerTest extends TestCase
{
    /** @test */
    public function test_can_get_users_status_200()
    {
        $user = factory(User::class, 10)->create();
        $response = $this->get('/api/users/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_create_an_user_status_201()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->post('/api/users', $data);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_update_an_user_status_200()
    {
        $user = factory(User::class)->create();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->put('/api/users/'.$user->id, $data);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_can_delete_an_team_status_204()
    {
        $user = factory(User::class)->create();
        $this->delete('/api/users/'.$user->id)
            ->assertStatus(204);
    }

    /** @test */
    public function test_cant_delete_an_team_status_404()
    {
        $this->delete('/api/users/1')
            ->assertStatus(404);
    }
}
