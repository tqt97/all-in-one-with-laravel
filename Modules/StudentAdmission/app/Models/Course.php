<?php

namespace Modules\StudentAdmission\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// use Modules\StudentAdmission\Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];

    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }
}
