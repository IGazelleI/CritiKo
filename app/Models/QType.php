<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    //Qquestion relationship
    public function question()
    {
        return $this->hasMany(Question::class, 'q_type_id');
    }
}
