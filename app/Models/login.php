<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{

   public function info()
{
    return $this->hasOne(Info::class, 'Login_id', 'Login_id');
}


    use HasFactory;

    protected $table = 'login';

    protected $primaryKey = 'Login_id'; // if your PK is named differently

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    public $timestamps = false;

     public function evaluator()
    {
        return $this->hasOne(EvaluatorInfo::class, 'Login_id', 'Login_id');
    }
}

