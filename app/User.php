<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }
}
