<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationLevel extends Model
{
    use HasFactory;

    protected $table = 'qualification_level';
    protected $primaryKey = 'QualityLevelID';
    public $timestamps = false;

    protected $fillable = [
        'Level',
        'From',
        'To',
        'CriteriaID',
    ];

 
    public function criteria()
{
    return $this->belongsTo(Criteria::class, 'CriteriaID', 'criteriaID'); // ✅ fixed spelling
}

}
