<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictSupervisor extends Model
{
    protected $table = 'district_supervisors'; // Confirmed table name

    protected $primaryKey = 'DistrictSupervisorID'; // ✅ Use correct primary key

    public $timestamps = false;

    protected $fillable = [
        'id',              // optional foreign key (e.g., reference to info table)
        'TitleName',
        'DistrictName',
    ];

    // Example relationship (optional: only if `id` refers to another model like Info)
    public function info()
    {
        return $this->belongsTo(Info::class, 'id', 'id');
    }
}
