<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionOfficerInfo extends Model
{
    // Specify custom table name if it doesn't follow Laravel's plural convention
    protected $table = 'division_officer_info';

    protected $primaryKey = 'DivisionofficerID';

    public $timestamps = false; // unless you decide to add created_at and updated_at

    protected $fillable = [
        'province_id',
        'firstname',
        'middlename',
        'lastname',
        'phonenumber',
        'email',
    ];

    // Relationship to province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
}
