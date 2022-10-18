<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_id', 'q_category_id', 'points'];
    //faculty relationship
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'user_id');
    }
    //question category relationship
    public function category()
    {
        return $this->belongsTo(QCategory::class, 'q_category_id');
    }
}
