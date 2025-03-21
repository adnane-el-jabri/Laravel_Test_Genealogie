<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $fillable = [
        'created_by', 'first_name', 'last_name',
        'birth_name', 'middle_names', 'date_of_birth'
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Relationship::class, 'parent_id');
    }

    public function parents(): HasMany
    {
        return $this->hasMany(Relationship::class, 'child_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
