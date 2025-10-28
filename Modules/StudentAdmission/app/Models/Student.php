<?php

namespace Modules\StudentAdmission\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// use Modules\StudentAdmission\Database\Factories\StudentFactory;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'application_id',
        'expires_at',
        'accepted_at',
        'rejected_at',
    ];

    // protected static function newFactory(): StudentFactory
    // {
    //     // return StudentFactory::new();
    // }
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }
}
