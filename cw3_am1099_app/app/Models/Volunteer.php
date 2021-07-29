<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;




class Volunteer extends Model implements
    \Illuminate\Contracts\Auth\Authenticatable
{
    use HasFactory, Authenticatable;

    public $timestamps = false;
    public $incrementing = false;

    protected $guard = 'volunteer';

    protected $table = 'volunteers';

    protected $primaryKey = 'email';


    public function getAuthPassword()
    {
        return $this->passwordHash;
    }

    public function vaccine()
    {
        return $this->hasOne(Vaccine::class);
    }

    protected $fillable = [
        'email',
        'fullname',
        'gender',
        'age',
        'address',
        'health_condition',
        'passwordHash',
        'vaccineGroup',
        'infected',
    ];


    protected $hidden = [
       
        'passwordHash',
    ];
}
