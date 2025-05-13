<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipalities extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'municipalities';

    // Define the fillable attributes
    protected $fillable =
    ['municipalities',
    'provinces_id'];

    // Define the relationship with the Province model
    public function provinces()
    {
        return $this->belongsTo(Provinces::class, 'provinces_id');
    }
    public function barangays()
    {
        return $this->hasMany(Barangays::class);
    }


}
