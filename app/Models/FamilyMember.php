<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'maiden_name',
        'gender',
        'address',
        'life_description',
        'is_alive',
        'mother_id',
        'father_id',
        'spouse_id',
        'death_date',
        'birth_date'
    ];

    protected $casts = [
        'address' => 'array',
        'is_alive' => 'boolean',
    ];


    protected static function parseStoredDate(?string $value): ?Carbon
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }
        $value = trim($value);
        // 1. Canonical format (no ambiguity, no timezone shift)
        $parsed = Carbon::createFromFormat('Y', $value);
        if ($parsed !== false) {
            return $parsed;
        }
        // 2. Excel serial number (e.g. "44927") – Carbon::parse would treat as Unix timestamp (wrong)
        if (ctype_digit($value) || (str_starts_with($value, '-') && ctype_digit(substr($value, 1)))) {
            $days = (int) $value;
            if ($days >= 1 && $days <= 100000) {
                return Carbon::create(1899, 12, 30)->addDays($days)->startOfDay();
            }
        }
        // 3. Fallback for d/m/Y, d-m-Y, etc.
        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /** Parsed birth_date for display (handles all stored formats). */
    public function getParsedBirthDateAttribute(): ?Carbon
    {
        return static::parseStoredDate($this->attributes['birth_date'] ?? null);
    }

    /** Parsed death_date for display (handles all stored formats). */
    public function getParsedDeathDateAttribute(): ?Carbon
    {
        return static::parseStoredDate($this->attributes['death_date'] ?? null);
    }

    protected $attributes = [
        'is_alive' => true,
    ];

    protected static function booted(): void
    {
        static::deleting(function (FamilyMember $member) {
            if ($member->spouse_id) {
                static::query()
                    ->whereKey($member->spouse_id)
                    ->where('spouse_id', $member->id)
                    ->update(['spouse_id' => null]);
            }
        });
    }

    /**
     * After spouse_id is saved on this member, set the partner's spouse_id to this member,
     * clear any stale reciprocal links, and set this member's children's other parent to the
     * new spouse when that side was empty or still pointed at the previous spouse; and the same
     * for the partner's children pointing back at this member.
     *
     * @param  int|null  $previousSpouseId  spouse_id before this save (null on create)
     */
    public static function applyBidirectionalSpouse(FamilyMember $member, ?int $previousSpouseId): void
    {
        $memberId = (int) $member->id;
        $newSpouseId = $member->spouse_id !== null && $member->spouse_id !== ''
            ? (int) $member->spouse_id
            : null;

        if ($newSpouseId === $memberId) {
            $member->update(['spouse_id' => null]);

            return;
        }

        if ($previousSpouseId !== null && $previousSpouseId !== $newSpouseId) {
            static::query()
                ->whereKey($previousSpouseId)
                ->where('spouse_id', $memberId)
                ->update(['spouse_id' => null]);
        }

        if ($newSpouseId) {
            $partner = static::lockForUpdate()->find($newSpouseId);
            $partnerPreviousSpouseId = null;
            if ($partner) {
                $pid = $partner->spouse_id !== null && $partner->spouse_id !== ''
                    ? (int) $partner->spouse_id
                    : null;
                if ($pid !== null && $pid !== $memberId) {
                    $partnerPreviousSpouseId = $pid;
                }
            }
            if ($partner && $partner->spouse_id && (int) $partner->spouse_id !== $memberId) {
                static::query()
                    ->whereKey($partner->spouse_id)
                    ->where('spouse_id', $partner->id)
                    ->update(['spouse_id' => null]);
            }
            static::query()->whereKey($newSpouseId)->update(['spouse_id' => $memberId]);

            static::linkChildrenOtherParent($memberId, (string) $member->gender, $newSpouseId, $previousSpouseId);
            if ($partner) {
                static::linkChildrenOtherParent($newSpouseId, (string) $partner->gender, $memberId, $partnerPreviousSpouseId);
            }
        }
    }

    /**
     * For children where $parentId is father (male) or mother (female), set the other parent to
     * $otherParentId when that field is null or still references a former spouse of $parentId.
     */
    private static function linkChildrenOtherParent(
        int $parentId,
        string $parentGender,
        int $otherParentId,
        ?int $priorOtherParentOnChild
    ): void {
        if ($parentGender === 'male') {
            static::query()
                ->where('father_id', $parentId)
                ->where(function ($q) use ($priorOtherParentOnChild) {
                    $q->whereNull('mother_id');
                    if ($priorOtherParentOnChild !== null) {
                        $q->orWhere('mother_id', $priorOtherParentOnChild);
                    }
                })
                ->update(['mother_id' => $otherParentId]);
        } elseif ($parentGender === 'female') {
            static::query()
                ->where('mother_id', $parentId)
                ->where(function ($q) use ($priorOtherParentOnChild) {
                    $q->whereNull('father_id');
                    if ($priorOtherParentOnChild !== null) {
                        $q->orWhere('father_id', $priorOtherParentOnChild);
                    }
                })
                ->update(['father_id' => $otherParentId]);
        }
    }

    public function mother()
    {
        return $this->belongsTo(FamilyMember::class, 'mother_id');
    }

    public function father()
    {
        return $this->belongsTo(FamilyMember::class, 'father_id');
    }

    public function spouse()
    {
        return $this->belongsTo(FamilyMember::class, 'spouse_id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_family_member')
            ->withTimestamps()
            ->orderBy('countries.name');
    }

    public function children()
    {
        return $this->hasMany(FamilyMember::class, 'father_id');
    }

    public function childrenByFather()
    {
        return $this->hasMany(FamilyMember::class, 'father_id');
    }

    public function childrenByMother()
    {
        return $this->hasMany(FamilyMember::class, 'mother_id');
    }

    public function allChildren()
    {
        return FamilyMember::where(function($query) {
            $query->where('father_id', $this->id)
                  ->orWhere('mother_id', $this->id);
        });
    }

    /**
     * All children (whether this member is father or mother). Use for display.
     */
    public function getAllChildrenAttribute()
    {
        $byFather = $this->relationLoaded('children') ? $this->children : $this->children()->get();
        $byMother = $this->relationLoaded('childrenByMother') ? $this->childrenByMother : $this->childrenByMother()->get();
        return $byFather->merge($byMother)->unique('id')->sortBy('birth_date')->values();
    }

    /**
     * Display name: first name, then father's first name, then last name.
     */
    public function getDisplayNameAttribute(): string
    {
        $parts = [$this->first_name];
        if ($this->relationLoaded('father') && $this->father) {
            $parts[] = $this->father->first_name;
        } elseif ($this->father_id) {
            $parts[] = self::find($this->father_id)?->first_name ?? '';
        }
        $parts[] = $this->last_name;

        return implode(' ', array_filter($parts));
    }

    public function hasChildByName(string $name): bool
    {
        return $this->allChildren()
            ->where('first_name', $name)
            ->exists();
    }

      // Search scopes
      public function scopeNameLike($query, $name)
      {
          return $query->where('first_name', 'LIKE', "%{$name}%");
      }
  
      public function scopeWithFatherName($query, $fatherName)
      {
          return $query->whereHas('father', function($q) use ($fatherName) {
              $q->where('first_name', 'LIKE', "%{$fatherName}%");
          });
      }
      
}