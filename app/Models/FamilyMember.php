<?php

namespace App\Models;

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
        'mother_id',
        'father_id',
        'spouse_id'
    ];

    protected $casts = [
        'address' => 'array',
    ];

    // Relationships
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

    public function children()
    {
        return $this->hasMany(FamilyMember::class, 'mother_id')
            ->orWhere('father_id', $this->id);
    }

    public function hasChildByName(string $name): bool
    {
        return $this->children()
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