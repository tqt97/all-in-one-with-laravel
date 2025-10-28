<?php

namespace Modules\StudentAdmission\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

// use Modules\StudentAdmission\Database\Factories\ApplicationFactory;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'status',
        'score',
        'notes',
    ];

    // protected static function newFactory(): ApplicationFactory
    // {
    //     // return ApplicationFactory::new();
    // }

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
        ];
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }
}
