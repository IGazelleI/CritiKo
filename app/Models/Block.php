<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected  $fillable = ['course_id', 'year_level', 'section', 'user_id'];

    //course relationship
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    //faculty relationship
    public function adviser()
    {
        return $this->hasMany(Faculty::class, 'user_id');
    }
    //block student relationship
    public function blockStudents()
    {
        return $this->hasMany(BlockStudent::class, 'block_id');
    }
}
