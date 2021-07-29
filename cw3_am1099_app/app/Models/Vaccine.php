<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $guard = 'vaccine_maker';

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'vaccines';

    protected $primaryKey = 'vaccineGroup';

    public function getdata(){

        return $this->BelongsTo('Volunteer');
    }

    

    

}
