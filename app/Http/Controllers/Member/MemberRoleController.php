<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\ApiController;
use App\TeamMember;

class MemberRoleController extends ApiController
{
    protected function setRole(int $member_id, int $role_id)
    {
        $team_member = TeamMember::findOrFail($member_id);
        $team_member->role_id = $role_id;
        $team_member->save();

        return response()->json([
          'data' => [
            'member_id' => $team_member->id,
            'team_id' => $team_member->team->id,
            'member_name' => $team_member->user->name,
            'owner_name' => $team_member->team->owner,
            'team_title' => $team_member->team->title,
            'role' => $team_member->role,
            'role_id' => $team_member->role_id,
          ],
        ]);
    }
}
