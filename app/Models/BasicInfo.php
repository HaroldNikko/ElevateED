<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicInfo extends Model
{
    use HasFactory;

    protected $table = 'basic_info';
    protected $primaryKey = 'basicinfoID';
    public $timestamps = false;

    protected $fillable = [
        'teacherID',
        'uploadID',
        'ApplicantID',
        'Firstname',
        'MiddleName',
        'LastName',
        'CurrentPosition',
        'email',
        'contactnumber',
        'schoolname',
        'Address',
        'schooladdress',
        'Status',
        'submitDate',
    ];

    // Foreign key relationship to info table
    public function teacher()
    {
        return $this->belongsTo(Info::class, 'teacherID', 'id');
    }
     public function Position()
    {
        return $this->belongsTo(UploadPosition::class, 'uploadID', 'uploadID');
    }
}
