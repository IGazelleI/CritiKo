<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'code', 'name'];

    public function scopeFilter($query, array $filters)
    {
        if($filters['course_id'] ?? false)
        {
            $query->where('course_id', '=', request('course_id'));
        }
    }
    //course relationship
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    //block relationship
    public function blocks()
    {
        return $this->hasMany(Block::class, 'subject_id');
    }
}
