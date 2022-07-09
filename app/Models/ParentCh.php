<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ParentCh extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'parents';
    protected $hidden = [
        'created_at',
        'updated_at',
        'password'
    ];
    protected $fillable = [
        'fatherName',
        'motherName',
        'fatherLastName',
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
    
    public function phone_numbers()
    {
        return $this->hasMany(ParentPhoneNumbers::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Children::class,'parent_id');
    }


}
