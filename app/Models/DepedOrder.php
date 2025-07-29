<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepedOrder extends Model
{
    use HasFactory;

    protected $table = 'deped_order'; // Assuming table name is `deped_orders`

    protected $primaryKey = 'DepedID';

    public $timestamps = false;

    protected $fillable = [
        'filename',
        'year',
    ];
}
