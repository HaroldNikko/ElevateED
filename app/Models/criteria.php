<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criteria';
    protected $primaryKey = 'criteriaID';
    public $timestamps = false;

    protected $fillable = [
        'criteriaDetail',
        'maxpoint',
        'date',
        'DepedID', // ✅ Added this
    ];

    public function qualityStandards()
    {
        return $this->hasMany(QualityStandard::class, 'criteriaID', 'criteriaID');
    }

    public function qualificationLevels()
    {
        return $this->hasMany(QualificationLevel::class, 'CriteriaID', 'criterialID');
    }

    public function depedOrder()
    {
        return $this->belongsTo(DepedOrder::class, 'DepedID', 'DepedID');
    }
}
