<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherRank extends Model
{
    use HasFactory;

    protected $table = 'teacher_rank';
    protected $primaryKey = 'teacher_rankID';
    public $timestamps = false;

   protected $fillable = [
        'teacherRank',
        'Salary_grade', // ✅ Add this
    ];

}
