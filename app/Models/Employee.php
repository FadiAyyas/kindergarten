<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'firstName',
        'lastName',
        'photo',
        'phoneNumber',
        'gender',
        'address',
        'role',
        'age',
        'email',
        'password'
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function class()
    {
        return $this -> belongsToMany(KGClass::class,'teacher_classes','employee_id','class_id')->withTimestamps();
    }

}
