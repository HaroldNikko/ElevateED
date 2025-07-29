<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedEvaluator extends Model
{
    protected $table = 'assigned_evaluator';
    protected $primaryKey = 'assignID';
    public $timestamps = false;

    protected $fillable = [
        'evaluatorID',
        'uploadID',
    ];

    public function evaluator()
    {
        return $this->belongsTo(Info::class, 'evaluatorID');
    }

    public function uploadPosition()
    {
        return $this->belongsTo(UploadPosition::class, 'uploadID');
    }
}
