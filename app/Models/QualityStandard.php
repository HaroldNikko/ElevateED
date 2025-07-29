<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityStandard extends Model
{
    use HasFactory;

    protected $table = 'quality_standard';
    protected $primaryKey = 'QualityID';
    public $timestamps = false;

    protected $fillable = [
        'DepedID', // ✅ Newly added foreign key
        'teacher_RankID',
        'CriteriaID',
        'QualityStandard',
        'level',
    ];

    // 🔗 Relationship to Criteria
    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'CriteriaID', 'criteriaID');
    }

    // 🔗 Relationship to Teacher Rank
    public function teacherRank()
    {
        return $this->belongsTo(TeacherRank::class, 'teacher_RankID', 'teacher_rankID');
    }

    // 🔗 Relationship to Deped Order
    public function depedOrder()
    {
        return $this->belongsTo(DepedOrder::class, 'DepedID', 'DepedID');
    }
}
