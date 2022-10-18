<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalDet extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'answer', 'evaluation_id'];
    //question relationship
    public function question()
    {
        return $this->hasMany(Question::class, 'question_id');
    }
    //evaluation relationship
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }
}
