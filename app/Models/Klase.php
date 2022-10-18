<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klase extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'block_id', 'user_id'];
    //klaes det relationship
    public function klaseDet()
    {
        return $this->hasMany(KlaseDet::class, 'klase_id');
    }
}
