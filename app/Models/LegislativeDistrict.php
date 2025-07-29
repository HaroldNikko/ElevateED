<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegislativeDistrict extends Model
{
    protected $table = 'legislative_districts';
    protected $primaryKey = 'district_id';
    public $timestamps = false;

    protected $fillable = ['province_id', 'district_name'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'district_id');
    }
}
