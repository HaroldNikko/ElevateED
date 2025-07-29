<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalPoint extends Model
{
    use HasFactory;

    protected $table = 'total_points';
    protected $primaryKey = 'totalID';
    public $timestamps = false;

    protected $fillable = [
        'teacherID',
        'uploadID',
        'total_points',
    ];

    // 🔗 Relationships

    public function teacher()
    {
        return $this->belongsTo(Info::class, 'teacherID', 'id'); 
        // Replace 'id' if the primary key in the info table is different
    }

    public function uploadPosition()
    {
        return $this->belongsTo(UploadPosition::class, 'uploadID', 'uploadID');
    }
    public function info()
{
    return $this->belongsTo(\App\Models\Info::class, 'teacherID', 'id');
}

}
