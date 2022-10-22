<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'period_id', 'course_id', 'year_level', 'status'];
    //period relationship
    public function period()
    {
        return $this->hasMany(Period::class, 'period_id');
    }
    //course relationship
    public function course()
    {
        return $this->hasmany(Course::class, 'id');
    }
}
