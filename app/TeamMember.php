<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    // assoc to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // assoc to Team
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
