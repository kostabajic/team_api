<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\ApiController;
use App\Team;
use App\TeamMember;
use App\User;
use Illuminate\Http\Request;

class TeamUserController extends ApiController
{
    protected function setTeamOwner(int $team_id, int $user_id)
    {
        $team = Team::findOrFail($team_id);
        $team->owner()->associate(User::find($user_id));
        $team->save();

        return $this->getTeamOwner($team_id);
    }

    protected function getTeamOwner(int $team_id)
    {
        $team = Team::findOrFail($team_id);
        $teamOwner = User::findOrFail($team->owner_id);

        return response()->json([
            'data' => [
                'user_id' => $teamOwner->id,
                'name' => $teamOwner->name,
            ],
        ]);
    }

    protected function deleteTeamOwner(int $team_id)
    {
        $team = Team::findOrFail($team_id);
        $team->owner()->dissociate();
        $team->save();

        return response()->json([], 204);
    }

    protected function getTeamMembers(int $team_id)
    {
        $query = TeamMember::with('user')->whereteam_id($team_id);

        return response()->json([
            'data' => $query->get()->map(function ($teamMember) {
                return [
                    'user_id' => $teamMember->user_id,
                    'member_id' => $teamMember->id,
                    'member_name' => $teamMember->user->name,
                    'role' => $teamMember->role,
                    'role_id' => $teamMember->role_id,
                ];
            }),
        ]);
    }

    protected function updateTeamMembers(int $team_id, Request $request)
    {
        $this->validate($request, [
            'member_user_ids' => 'required|array',
            'member_user_ids.*' => 'int',
        ]);
        $member_user_ids = $request->input('member_user_ids');
        $team = Team::findOrfail($team_id);
        $team->members()->sync($member_user_ids);

        return $this->getTeamMembers($team_id);
    }

    protected function addTeamMember(int $team_id, int $user_id)
    {
        $team = Team::findOrFail($team_id);
        $user = User::findOrFail($user_id);
        $team->members()->attach($user);

        return $this->getTeamMembers($team_id);
    }
}
