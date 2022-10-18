<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaseDet extends Model
{
    use HasFactory;

    protected $fillable = ['klase_id', 'user_id'];
    //klase relationship
    public function klase()
    {
        return $this->belongsTo(Klase::class, 'klase_id');
    }    
}
