<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDesignation extends Model
{
    use HasFactory;

    protected $table = 'userdesignation';
    protected $primaryKey = 'userDesignaionID';
    public $timestamps = false;

    protected $fillable = [
        'region_id',
        'province_id',
        'district_id',
        'municipality_id',
        'schoolID',
        'id',
        'designationID',
    ];

    // Relationships
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(LegislativeDistrict::class, 'district_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function school()
    {
        return $this->belongsTo(SchoolDetail::class, 'schoolID');
    }

    public function teacher()
    {
        return $this->belongsTo(Info::class, 'id', 'id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designationID', 'designationID');
    }
}
