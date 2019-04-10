<?php

namespace Tests\Feature\Member;

use Tests\TestCase;
use App\User;
use App\Team;

class MemberControllerTest extends TestCase
{
    /** @test */
    public function test_can_change_member_role_status_200()
    {
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();
        $team->members()->attach($user);
        $member_ids = $team->members->pluck('id')->toArray();
        $new_role = 2;
        $response = $this->put('/api/member/'.$member_ids[0].'/roles/'.$new_role);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
