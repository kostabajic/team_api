<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
    ];

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

    public function getRoleAttribute()
    {
        return  Role::whereId($this->getAttribute('role_id'))->first()->title;
    }
}
