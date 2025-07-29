<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedFile extends Model
{
    protected $table = 'importedfile'; // name of your table

    protected $primaryKey = 'importedID'; // your primary key

    public $timestamps = false; // set to true if you add created_at/updated_at

    protected $fillable = [
        'importedFile' // this allows mass assignment
    ];
}
