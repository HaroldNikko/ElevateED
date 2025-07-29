<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolDetail extends Model
{
    use HasFactory;

    protected $table = 'schooldetails';
    protected $primaryKey = 'schoolID';
    public $timestamps = false;

    protected $fillable = [
        'Schoolname',
        'Basic_education',
        'district_id',
        'municipality_id',
        'region_id',
        'province_id',
        'barangay_id',
    ];

    // ✅ Relationships
    public function district()
    {
        return $this->belongsTo(LegislativeDistrict::class, 'district_id', 'district_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'municipality_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'region_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    // Custom method to get full school address
    public function getSchoolAddressAttribute()
    {
        // Concatenate province, municipality, and barangay to form school address
        return $this->province->name . ', ' . $this->municipality->name . ', ' . $this->barangay->name;
    }

    public function teachers()
    {
        return $this->hasManyThrough(
            \App\Models\Info::class,
            \App\Models\UserDesignation::class,
            'schoolID',     // Foreign key on userdesignation table...
            'id',           // Foreign key on info table...
            'schoolID',     // Local key on schooldetails...
            'id'     // Local key on userdesignation table...
        )->whereHas('login', function ($q) {
            $q->where('role', 'teacher');
        });
    }

    public function evaluators()
    {
        return $this->hasMany(EvaluatorInfo::class, 'schoolID', 'schoolID');
    }

    public function school()
    {
        return $this->hasMany(UploadPosition::class, 'schoolID', 'schoolID');
    }
}
