<?php

namespace App\Models;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory; 
    
    protected $fillable = ['name', 'abbre'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id');
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'department_id');
    }
}
