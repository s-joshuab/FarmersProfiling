<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'provinces';

    // Define the fillable attributes
    protected $fillable = ['provinces', 'regions_id'];

    // Define the relationship with the Region model
    public function regions()
    {
        return $this->belongsTo(Regions::class, 'regions_id');
    }
}
