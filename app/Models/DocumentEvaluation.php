<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentEvaluation extends Model
{
    use HasFactory;

    protected $table = 'document_evaluations';
    protected $primaryKey = 'documentID';
    public $timestamps = false;

    protected $fillable = [
        'uploadID',
        'teacherID',
        'criteriaID',
        'QualityLevelID', // ✅ Newly added for foreign key reference
        'title',
        'description',     // ✅ Also add this if it's used in form
        'achievement_cat',
        'date_presented',
        'upload_file',
        'faculty_score',
        'StatusOfDocument',
        'Comment',
    ];

    // 🔗 Relationships

    public function teacher()
    {
        return $this->belongsTo(Info::class, 'teacherID', 'id'); 
    }

    public function uploadPosition()
    {
        return $this->belongsTo(UploadPosition::class, 'uploadID', 'uploadID');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteriaID', 'criteriaID');
    }

   public function qualificationLevel()
{
    return $this->belongsTo(QualificationLevel::class, 'QualityLevelID', 'QualityLevelID'); // ✅ Match PK to FK
}

}
