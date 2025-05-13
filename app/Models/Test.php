<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table= 'test';

    protected $fillable = [
        'barangay_id',
        'municipality_id',
        'province_id',
    ];
}
