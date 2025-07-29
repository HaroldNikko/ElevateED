<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designation'; // Table name
    protected $primaryKey = 'designationID'; // Primary key
    public $timestamps = false; // No created_at / updated_at

    protected $fillable = [
        'designation_name',
        'access',
    ];
}
