<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $table = 'table_barangay';
    protected $primaryKey = 'barangay_id';
    public $timestamps = false;

    protected $fillable = ['municipality_id', 'barangay_name'];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
}
