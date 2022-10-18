<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = ['department_id', 'name', 'abbre'];
    //para sa filter sa query
    /* public function scopeFilter($query, array $filters)
    {
        if($filters['department_id'] ?? false)
        {
            $query->where('department_id', '=', $filters['department']);
        }
    } */
    //department relationship
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    //subject relationship
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'course_id');
    }
}
