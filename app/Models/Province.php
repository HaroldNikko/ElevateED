<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'table_province';
    protected $primaryKey = 'province_id';
    public $timestamps = false;

    protected $fillable = ['region_id', 'province_name'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'province_id');
    }
}
