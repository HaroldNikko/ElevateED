<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class system_log extends Model
{
    use HasFactory;

    protected $table = 'system_logs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'Login_id',
        'action',
        'section',
        'ip',
    ];

    public $timestamps = true;

    // Relationship to login table
    public function login()
    {
        return $this->belongsTo(\App\Models\Login::class, 'Login_id', 'Login_id');
    }
}
