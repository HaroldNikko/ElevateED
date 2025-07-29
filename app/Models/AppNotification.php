<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



   class AppNotification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    // Allow only created_at to be tracked
    const UPDATED_AT = null;

    public $timestamps = true; // ✅ Still needed so Laravel handles created_at

    protected $fillable = [
        'teacherID',
        'message',
        'is_read',
    ];

    public function teacher()
    {
        return $this->belongsTo(Info::class, 'teacherID', 'id');
    }
}


