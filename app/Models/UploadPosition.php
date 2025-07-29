<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadPosition extends Model
{
    use HasFactory;

    protected $table = 'upload_position';
    protected $primaryKey = 'uploadID';
    public $timestamps = false;

    protected $fillable = [
        'schoolID',
        'teacher_rankID',
        'track_code',
        'start_date',
        'end_date',
        'DistrictSupervisorID',
    ];

    // Optional relationships
    public function districtSupervisor()
{
    return $this->belongsTo(\App\Models\Info::class, 'DistrictSupervisorID', 'id');
}

    public function school()
    {
        return $this->belongsTo(SchoolDetail::class, 'schoolID', 'schoolID');
    }

    public function teacherRank()
    {
        return $this->belongsTo(TeacherRank::class, 'teacher_rankID', 'teacher_rankID');
    }
    public function totalPoints()
{
    return $this->hasMany(\App\Models\TotalPoint::class, 'uploadID', 'uploadID');
}




}
