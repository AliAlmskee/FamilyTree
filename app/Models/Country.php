<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'flag_path',
    ];

    public function familyMembers(): BelongsToMany
    {
        return $this->belongsToMany(FamilyMember::class, 'country_family_member')
            ->withTimestamps();
    }

    public function getFlagUrlAttribute(): ?string
    {
        if (empty($this->flag_path)) {
            return null;
        }

        return asset('storage/'.$this->flag_path);
    }
}
