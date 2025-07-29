<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Info; // <-- reference to Info model

class TeacherInfo extends Model
{
    protected $table = 'teacherinfo'; // Table name
    protected $primaryKey = 'id';     // Primary key (FK to info.id)
    public $timestamps = false;       // Disable if table has no created_at/updated_at

    protected $fillable = [
        'TeacherID',
        'id',             // FK to info table
        'applicantID',
        'TitleName',
        'currentrank',
        'currentyear',
        'endyear',
    ];

    // Relationship to Info table
    public function info()
    {
        return $this->belongsTo(Info::class, 'id', 'id');
        // 'id' = local FK (in this table), 'id' = PK in info table
    }
}
