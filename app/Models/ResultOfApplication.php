<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultOfApplication extends Model
{
    use HasFactory;

    protected $table = 'resultofapplication';
    protected $primaryKey = 'resultID';
    public $timestamps = false;

    protected $fillable = [
        'uploadID',
        'teacherID',
    ];

    /**
     * Get the teacher info associated with this result.
     */
    public function teacher()
    {
        return $this->belongsTo(Info::class, 'teacherID', 'id');
    }

    /**
     * Get the upload position associated with this result.
     */
    public function uploadPosition()
    {
        return $this->belongsTo(UploadPosition::class, 'uploadID', 'uploadID');
    }
}
