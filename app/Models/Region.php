<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'table_region';
    protected $primaryKey = 'region_id';
    public $timestamps = false;

    protected $fillable = ['region_name', 'region_description'];

    public function provinces()
    {
        return $this->hasMany(Province::class, 'region_id');
    }
}
