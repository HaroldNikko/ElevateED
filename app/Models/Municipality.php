<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table = 'table_municipality';
    protected $primaryKey = 'municipality_id';
    public $timestamps = false;

    protected $fillable = ['province_id', 'municipality_name', 'district_id'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'municipality_id');
    }

    public function legislativeDistrict()
    {
        return $this->belongsTo(LegislativeDistrict::class, 'district_id');
    }
}
