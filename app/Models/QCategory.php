<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    //Qquestion relationship
    public function question()
    {
        return $this->hasMany(Question::class, 'q_category_id');
    }
}
