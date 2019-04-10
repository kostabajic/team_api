<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\ApiController;
use App\Team;
use App\User;

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
}
