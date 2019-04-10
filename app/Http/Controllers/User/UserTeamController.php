<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;

class UserTeamController extends ApiController
{
    protected function getUserTeams(int $user_id)
    {
        try {
            $user = User::findOrfail($user_id);
        } catch (ModelNotFoundException $e) {
            return $this->userNotFound();
        }

        return $this->generateResponse($user);
    }

    protected function updateUserTeams(int $user_id, Request $request)
    {
        $this->validate($request, [
            'teams_ids' => 'required|array',
            'teams_ids.*' => 'int',
        ]);
        $teams_ids = $request->input('teams_ids');
        try {
            $user = User::findOrfail($user_id);
        } catch (ModelNotFoundException $e) {
            return $this->userNotFound();
        }

        $user->teams()->sync($teams_ids);

        return $this->generateResponse($user);
    }

    protected function addUserToTeam(int $user_id, int $team_id)
    {
        try {
            $user = User::findOrFail($user_id);
        } catch (ModelNotFoundException $e) {
            return $this->userNotFound();
        }
        $user->teams()->syncWithoutDetaching(array($team_id));

        return $this->generateResponse($user);
    }

    protected function generateResponse($user)
    {
        return response()->json([
            'data' => $user->members->map(function ($member) {
                return [
                    'member_id' => $member->id,
                    'team_id' => $member->team->id,
                    'owner_name' => $member->team->owner,
                    'team_title' => $member->team->title,
                    'role' => $member->role,
                ];
            }),
        ]);
    }
}
