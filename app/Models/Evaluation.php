<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['evaluator', 'evaluatee'];
    //evalDet relationship
    public function evalDet()
    {
        return $this->hasMany(EvalDet::class, 'evaluation_id');
    }
}
