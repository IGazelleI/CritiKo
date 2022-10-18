<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $fillable = ['q_type_id', 'q_category_id', 'sentence', 'keyword', 'type'];
    //Question Type Relationship
    public function questionType()
    {
        return $this->belongsTo(QType::class, 'q_type_id');
    }
    //Question Category Relationship
    public function questionCat()
    {
        return $this->belongsTo(QCategory::class, 'q_category_id');
    }
    //EvalDet relationship
    public function evalDet()
    {
        return $this->hasMany(EvalDet::class, 'question_id');
    }
}
