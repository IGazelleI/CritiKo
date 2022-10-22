<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Faculty;
use App\Models\Department;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["", "admin", "sast", "faculty", 'student'][$value],
        );
    }
    public function isDean()
    {
        $details = Faculty::select('isDean')
                        -> where('user_id', '=', auth()->user()->id)
                        -> get();

        foreach($details as $dets)
            $dean = $dets->isDean;

        return $dean;
    }

    //department relationship
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    //faculty relationship
    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'user_id');
    }
    //student relationship
    public function students()
    {
        return $this->hasMany(Student::class, 'user_id');
    }
}
