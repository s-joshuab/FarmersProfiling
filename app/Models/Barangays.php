<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangays extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'barangays';

    // Define the fillable attributes
    protected $fillable = ['barangays', 'municipalities_id'];

    // Define the relationship with the Municipality model
    public function municipalities()
    {
        return $this->belongsTo(Municipalities::class, 'municipalities_id');
    }
}
