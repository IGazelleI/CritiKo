<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    
    protected $fillable = ['description', 'begin', 'end'];
    //enrollment relationship
    public function enrollment()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
    //block relationship
    public function blocks()
    {
        return $this->hasMany(Block::class, 'period_id');
    }
}
