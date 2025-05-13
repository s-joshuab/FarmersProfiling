<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'regions';

    // Define the fillable attributes
    protected $fillable = ['regions'];
}
