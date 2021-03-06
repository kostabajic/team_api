<?php

namespace Tests\Feature\Member;

use Tests\TestCase;

class MemberControllerTest extends TestCase
{
    /** @test */
    public function test_can_change_member_role_status_200()
    {
        list($user, $team) = $this->createUserTeam();
        $team->members()->attach($user);
        $member_ids = $team->members->pluck('id')->toArray();
        $new_role = 2;
        $response = $this->put('/api/member/'.$member_ids[0].'/roles/'.$new_role);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function test_cant_wrong_metod_status_405()
    {
        list($user, $team) = $this->createUserTeam();
        $team->members()->attach($user);
        $member_ids = $team->members->pluck('id')->toArray();
        $new_role = 2;
        $content = $this->get('/api/member/'.$member_ids[0].'/roles/'.$new_role)->decodeResponseJson();
        $this->assertEquals(405, $content['code']);
        $this->assertEquals('This specified method for the request is invalid', $content['error']);
    }

    /** @test */
    public function test_can_change_member_role()
    {
        list($user, $team) = $this->createUserTeam();
        $team->members()->attach($user);
        $member_ids = $team->members->pluck('id')->toArray();
        $new_role = 2;
        $response = $this->put('/api/member/'.$member_ids[0].'/roles/'.$new_role);
        $content = $response->json('data');
        $this->assertEquals($new_role, $content['role_id']);
    }
}
