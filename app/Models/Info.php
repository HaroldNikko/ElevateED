<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{

    public function login()
{
    return $this->belongsTo(Login::class, 'Login_id', 'Login_id');
}

public function notifications()
{
    return $this->hasMany(Notification::class, 'teacherID', 'id');
}



    use HasFactory;

    protected $table = 'info'; // Ensure this matches your table name
    protected $primaryKey = 'id';
    protected $fillable = [
    'Login_id',
    'firstname',
    'middlename', // ✅ new
    'lastname',
    'email',
    'phonenumber', // ✅ new
    'Address', // ✅ new
    'profile'
];


    public $timestamps = false; // if your table does not have created_at / updated_at

     public function teacherInfo()
    {
        return $this->hasOne(TeacherInfo::class, 'id', 'id');
    }
    public function userdesignation()
{
    return $this->hasOne(\App\Models\UserDesignation::class, 'id', 'id');
}
public function school()
    {
        return $this->hasOneThrough(
            SchoolDetail::class,  // Target model
            UserDesignation::class, // Intermediate model
            'id',  // Foreign key on UserDesignation table
            'schoolID',  // Foreign key on SchoolDetail table
            'id',  // Local key on Info table
            'schoolID'  // Local key on UserDesignation table
        );
    }
}
