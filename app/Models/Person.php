<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
   
    public function getDegreeWith($target_person_id)
    {
        if ($this->id == $target_person_id) return 0;

        $visited = [];
        $queue = [[$this->id, 0]]; 

        while (!empty($queue)) {
            [$current_id, $degree] = array_shift($queue);

            if ($degree > 25) {
                return false;
            }

            if (isset($visited[$current_id])) continue;
            $visited[$current_id] = true;
            $neighbors = DB::select("
                SELECT parent_id AS id FROM relationships WHERE child_id = ?
                UNION
                SELECT child_id AS id FROM relationships WHERE parent_id = ?
            ", [$current_id, $current_id]);

            foreach ($neighbors as $neighbor) {
                $neighbor_id = $neighbor->id;

                if ($neighbor_id == $target_person_id) {
                    return $degree + 1;
                }

                if (!isset($visited[$neighbor_id])) {
                    $queue[] = [$neighbor_id, $degree + 1];
                }
            }
        }

        return false; 
    }

}
